// Run: node tests/purchase_order_datatable_test.js
const fs = require('node:fs');
const vm = require('node:vm');
const assert = require('node:assert/strict');
const html = fs.readFileSync('application/modules/purchase_order/views/index.php','utf8');
assert.match(html, /<tbody>\s*<\/tbody>/);
assert.doesNotMatch(html, /foreach\s*\(\$results/);
assert.doesNotMatch(html, /id="example1"/);
const scripts = [...html.replace(/<\?[\s\S]*?\?>/g,'').matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)].map(m=>m[1]).join('\n');
const document = {}, handlers = new Map(), requests = [], confirmations = [], reloads = [];
let config;
const api = {ajax: {reload(...args) { reloads.push(args); }}};
function $(key) {
    if (typeof key === 'function') { key(); return; }
    return {
        on(event, selector, callback) { handlers.set(selector,callback); return this; },
        DataTable(options) { if (options) config=options; return api; },
        hide() {}, data() { return 'P2600001'; }
    };
}
$.ajax = options => requests.push(options);
const context = {$, document, siteurl:'/', swal(options,callback) { if (callback) confirmations.push(callback); }};
vm.runInNewContext(scripts,context);
assert.equal(config.serverSide,true);
assert.equal(config.processing,true);
assert.equal(config.scrollX,true);
assert.equal(config.ajax.url,'/purchase_order/data_index');
assert.equal(config.ajax.type,'GET');
assert.equal(config.columns.length,6);
assert.equal(config.columns[0].orderable,false);
assert.equal(config.columns[5].orderable,false);
assert.deepEqual(Array.from(config.order),[]);
handlers.get('.Approve').call({}, {preventDefault() {}});
confirmations.shift()();
assert.equal(requests[0].url,'/purchase_order/Approved');
requests[0].success({status:'1'}); confirmations.shift()();
assert.deepEqual(reloads,[[null,false]]);
console.log('PASS: server-side initialization, isolated table ID, six columns and delegated approval refresh without browser');
