// Run: node tests/purchase_order_form_test.js
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const context = {Number, Math, isFinite, console, $: () => ({ready() {}}), document: {}};
vm.createContext(context);
vm.runInContext(fs.readFileSync('assets/js/purchase_order_form.js', 'utf8'), context);
const line = context.poLine({qty: 2, price: 100, discount: 0, fee: 0, taxable: true}, 11);
assert.equal(line.goods, 200);
assert.equal(line.tax, 22);
assert.equal(context.poRound(10.075), 10.08);
assert.equal(context.poRound(1.005), 1.01);
assert.equal(context.poTotals([line], 25).total, 247);
assert.equal(context.poTotals([], 25).tax, 0);
assert.equal(context.poTotals([], 25).total, 25);
const discounted = context.poLine({qty: 3, price: 10.125, discount: 10, fee: 2, taxable: true}, 11);
assert.equal(discounted.goods, 30.39);
assert.equal(discounted.tax, 3.34);
assert.equal(context.poTotals([discounted], 5).total, 37.69);
assert.equal(context.poLine({qty: 1, price: 100, discount: 0, fee: 0, taxable: false}, null).tax, 0);
assert.throws(() => context.poLine({qty: 1, price: 100, discount: 0, fee: 0, taxable: true}, null));
assert.equal(context.poTotals([context.poLine({qty: 3, price: 10.125, discount: 10, fee: 2, taxable: true}, 12)], 5).total, 38);
for (const name of ['Add.php', 'Edit.php', 'add_purchaseorder.php', 'index_pr.php', 'index.php', 'View.php']) {
    const html = fs.readFileSync('application/modules/purchase_order/views/' + name, 'utf8').replace(/<\?[\s\S]*?\?>/g, '');
    for (const match of html.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)) new vm.Script(match[1], {filename: name});
}
function formFixture(edit) {
    let ready;
    const handlers = new Map(), elements = new Map(), requests = [], confirmations = [], document = {};
    function $(key) {
        if (elements.has(key)) return elements.get(key);
        const state = {0: {}, length: 1};
        const chain = new Proxy(state, {get(target, property) {
            if (property in target) return target[property];
            if (property === 'ready') return fn => { ready = fn; return chain; };
            if (property === 'attr') return name => name === 'data-po-edit' ? (edit ? '1' : '') : '';
            if (property === 'prop') return (name, value) => { state[name] = value; return chain; };
            if (property === 'on') return (event, selector, fn) => { handlers.set(key + ':' + event, fn || selector); return chain; };
            if (property === 'trigger') return event => { handlers.get(key + ':' + event + '.po')({preventDefault() {}}); return chain; };
            if (property === 'map') return () => ({get: () => []});
            return () => chain;
        }});
        elements.set(key, chain); return chain;
    }
    $.ajax = options => requests.push(options);
    const c = {$, document, siteurl: '/', window: {location: {href: ''}}, FormData: class {},
        swal(options, callback) { if (typeof callback === 'function') confirmations.push(callback); }};
    vm.createContext(c); vm.runInContext(fs.readFileSync('assets/js/purchase_order_form.js', 'utf8'), c);
    c.poRecalculate = () => ({}); ready();
    return {requests, confirmations, button: $('#simpan-com'), context: c,
        click() { handlers.get('#simpan-com:click.po')({preventDefault() {}}); },
        submit() { handlers.get('#data-form:submit.po')({preventDefault() {}}); }};
}
for (const edit of [false, true]) {
    const f = formFixture(edit);
    f.click(); f.confirmations.shift()(false);
    assert.equal(f.requests.length, 0);
    assert.equal(f.button.disabled, false);
    f.click(); f.click(); f.submit();
    assert.equal(f.confirmations.length, 1);
    f.confirmations.shift()(true);
    assert.equal(f.requests.length, 1);
    assert.equal(f.button.disabled, true);
    assert.equal(f.requests[0].url, '/purchase_order/' + (edit ? 'SaveEdit' : 'SaveNew'));
    f.requests[0].error(); assert.equal(f.button.disabled, false);
    f.submit(); f.confirmations.shift()(true);
    f.requests[1].success({status: 0, pesan: 'Invalid'});
    assert.equal(f.button.disabled, false);
    f.submit(); f.confirmations.shift()(true);
    f.requests[2].success({status: 1}); f.click();
    assert.equal(f.requests.length, 3);
    assert.equal(f.context.window.location.href, '/purchase_order');
}
console.log('Purchase order calculation checks passed.');
