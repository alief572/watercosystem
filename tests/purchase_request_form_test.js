// Run: node tests/purchase_request_form_test.js
const fs = require('node:fs');
const vm = require('node:vm');
const assert = require('node:assert/strict');
const root = require('node:path').join(__dirname, '../application/modules/purchase_request/views/');
function scripts(name) {
  return [...fs.readFileSync(root + name, 'utf8').matchAll(/<script\b([^>]*)>([\s\S]*?)<\/script>/gi)]
    .filter(match => !/\bsrc\s*=/.test(match[1]))
    .map(match => match[2].replace(/<\?[\s\S]*?\?>/g, '')).join('\n');
}
for (const name of ['Add.php','Addpr.php','Edit.php','View.php','index.php','index_approval.php']) new vm.Script(scripts(name), {filename:name});
function form(name, rows = []) {
  const handlers = new Map(), elements = new Map(), requests = [], confirmations = [];
  const document = {};
  function $(key) {
    if (typeof key === 'function') { key(); return; }
    if (elements.has(key)) return elements.get(key);
    const state = {0:{}, length:0, disabled:false, count:0};
    const chain = new Proxy(state, {get(target, property) {
      if (property in target) return target[property];
      if (property === 'ready') return fn => { fn(); return chain; };
      if (property === 'on') return (event, fn) => { if (typeof fn === 'function') handlers.set(key+':'+event, fn); return chain; };
      if (property === 'click') return fn => { handlers.set(key+':click', fn); return chain; };
      if (property === 'trigger') return event => { handlers.get(key+':'+event)?.call(chain, {preventDefault(){}}); return chain; };
      if (property === 'each') return fn => { rows.forEach(id => fn.call({id:'tr_'+id})); return chain; };
      if (property === 'data') return (field, value) => { if (value !== undefined) state.count = value; return state.count; };
      if (property === 'prop') return (field, value) => { state[field] = value; return chain; };
      if (property === 'val') return () => key === '#tanggal' ? '2026-11-12' : '1';
      return () => chain;
    }});
    elements.set(key, chain); elements.set(chain, chain); return chain;
  }
  $.ajax = options => requests.push(options);
  const context = { $, document, siteurl:'/', window:{location:{href:''}}, FormData:class {},
    swal(options, callback) { if (typeof callback === 'function') confirmations.push(callback); } };
  vm.createContext(context); vm.runInContext(scripts(name), context);
  return {context, requests, confirmations, button:$('#simpan-com'),
    click() { handlers.get('#simpan-com:click')({preventDefault(){}}); },
    submit() { handlers.get('#data-form:submit')({preventDefault(){}}); },
    add() { if (name === 'Add.php') handlers.get('#tbh_ata:click').call($('#tbh_ata')); else context.addmaterial(); } };
}
for (const name of ['Add.php','Addpr.php','Edit.php']) {
  let fixture = form(name, [1,3]);
  fixture.click(); fixture.confirmations.shift()(false);
  assert.equal(fixture.requests.length, 0, name + ': cancelled confirmation sends nothing');
  fixture.click(); fixture.click();
  fixture.confirmations.splice(0).forEach(confirm => confirm(true));
  assert.equal(fixture.requests.length, 1, name + ': repeated confirmation sends one save');
  assert.equal(fixture.button.disabled, true);
  fixture.requests[0].complete();
  assert.equal(fixture.button.disabled, false, name + ': transport failure re-enables save');
  fixture.submit(); fixture.confirmations.shift()(true);
  assert.equal(fixture.requests.length, 2, name + ': Enter uses same save handler');
  fixture.requests[1].success({status:0,pesan:'Invalid'}); fixture.requests[1].complete();
  assert.equal(fixture.button.disabled, false, name + ': validation failure re-enables save');
  fixture.click(); fixture.confirmations.shift()(true);
  fixture.requests[2].success({status:1,pesan:'Saved'}); fixture.requests[2].complete();
  fixture.click();
  assert.equal(fixture.requests.length, 3, name + ': success stays locked until navigation');
  fixture = form(name, [1,3]); fixture.add(); fixture.add();
  const numbers = fixture.requests.map(request => Number(new URLSearchParams(request.data).get('jumlah')) + 1);
  assert.deepEqual(numbers, name === 'Add.php' ? [1,2] : [4,5], name + ': removed middle row cannot reuse an ID');
  if (name === 'Addpr.php') assert.equal(new URLSearchParams(fixture.requests[0].data).get('planning'), '1');
  console.log('PASS: ' + name + ' row IDs, save retries, duplicate guard, cancel and Enter');
}
console.log('PASS: six inline JavaScript scripts parse without a browser');
