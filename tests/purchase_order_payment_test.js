// Run: node tests/purchase_order_payment_test.js
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const source = fs.readFileSync('assets/js/purchase_order_payment.js', 'utf8');

function fixture(action = 'SavePembayaran') {
    const handlers = new Map(), requests = [], confirmations = [], notices = [], tables = [];
    const values = {'#tanggal_bayar': '2026-11-14', '#tanggal_request': '2026-11-13', '#total_bayar': '100.55', '#nominal_kurs': '1', '#matauang': 'idr', '#bank': '1102-01-01'};
    const attributes = {'data-payment-action': action, 'data-payment-base': '/purchase_order_payment/'};
    const buttons = {disabled: false, prop(key, value) { this[key] = value; return this; }};
    const form = {0: {}, length: 1,
        attr: key => attributes[key],
        find: key => key === ':submit' ? buttons : {val: () => values[key]},
        on(event, selector, fn) { handlers.set(event, fn || selector); return this; }};
    const table = {'data-url': '/purchase_order_payment/data_index'};
    function $(key) {
        if (typeof key === 'function') { key(); return; }
        if (key === '[data-payment-list]') return {each(fn) { fn.call(table); }};
        if (key === '#data-form[data-payment-action]') return form;
        return {attr: name => key && key[name], DataTable: config => tables.push(config)};
    }
    $.ajax = options => requests.push(options);
    const context = {jQuery: $, Number, window: {location: {href: ''}}, FormData: class {},
        swal(options, callback) { if (typeof callback === 'function') confirmations.push(callback); else notices.push(options); }};
    vm.runInNewContext(source, context);
    return {values, buttons, requests, confirmations, notices, tables, context,
        blur(value) { const field = {value}; handlers.get('blur').call(field); return field.value; },
        submit(override) { handlers.get('submit')({preventDefault() {}, originalEvent: {submitter: override ? {'data-payment-action': override} : {}}}); }};
}

for (const action of ['SaveRequest', 'SaveApproval', 'SavePembayaran']) {
    const f = fixture(action);
    const config = f.tables[0];
    assert.equal(config.serverSide, true);
    assert.equal(config.processing, true);
    assert.equal(config.scrollX, true);
    assert.equal(config.ajax.type, 'GET');
    assert.equal(config.ajax.url, '/purchase_order_payment/data_index');
    assert.deepEqual(Array.from(config.lengthMenu), [10, 25, 50, 100]);
    assert.equal(config.columns.length, 8);
    assert.equal(config.columns[0].orderable, false);
    assert.equal(config.columns[7].orderable, false);
    assert.equal(f.blur('1,234.5'), '1,234.50');
    assert.equal(f.blur('1,2'), '1,2');
    f.submit(); f.submit();
    assert.equal(f.confirmations.length, 1);
    f.confirmations.shift()(false);
    assert.equal(f.buttons.disabled, false);
    assert.equal(f.requests.length, 0);
    f.submit(); f.confirmations.shift()(true); f.submit();
    assert.equal(f.requests.length, 1);
    assert.equal(f.requests[0].url, '/purchase_order_payment/' + action);
    assert.equal(f.buttons.disabled, true);
    f.requests[0].error();
    assert.equal(f.buttons.disabled, false);
    f.submit(); f.confirmations.shift()(true);
    f.requests[1].success({status: 2, pesan: 'Invalid'});
    assert.equal(f.buttons.disabled, false);
    f.submit(); f.confirmations.shift()(true);
    f.requests[2].success({status: 1}); f.submit();
    assert.equal(f.requests.length, 3);
    assert.equal(f.context.window.location.href, '/purchase_order_payment/');
}
const reject = fixture('SaveApproval');
reject.submit('SaveReject'); reject.confirmations.shift()(true);
assert.equal(reject.requests[0].url, '/purchase_order_payment/SaveReject');
const request = fixture('SaveRequest');
request.values['#tanggal_request'] = ''; request.submit();
assert.equal(request.confirmations.length, 0);
request.values['#tanggal_request'] = '2026-11-13'; request.values['#tanggal_bayar'] = '';
request.submit(); assert.equal(request.confirmations.length, 1);
for (const value of ['0', '-1', '1,2', '0.001', '', '9'.repeat(400)]) {
    const f = fixture(); f.values['#total_bayar'] = value; f.submit();
    assert.equal(f.confirmations.length, 0);
}
const usd = fixture(); usd.values['#matauang'] = 'USD'; usd.values['#nominal_kurs'] = '0';
usd.submit(); assert.equal(usd.confirmations.length, 0);
usd.values['#nominal_kurs'] = '15,300.25'; usd.submit();
assert.equal(usd.confirmations.length, 1);
const bank = fixture(); bank.values['#bank'] = ''; bank.submit();
assert.equal(bank.confirmations.length, 0);
for (const name of ['index_incoming.php', 'index_approval.php', 'index_payment.php']) {
    const html = fs.readFileSync('application/modules/purchase_order_payment/views/' + name, 'utf8');
    assert.match(html, /<tbody>\s*<\/tbody>/);
    assert.doesNotMatch(html, /id="example1"|foreach\s*\(\$results/);
}
console.log('PASS: server-side tables, form validation, rejection, fractional formatting, duplicate submit, failure recovery, and success redirect');
