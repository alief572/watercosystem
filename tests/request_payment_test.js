// Run: node tests/request_payment_test.js; PAYMENT_TEST_DB=1 also validates native PHP-rendered forms.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const {spawnSync} = require('node:child_process');
const helpers = require('../assets/js/request_payment.js');
const source = fs.readFileSync('assets/js/request_payment.js', 'utf8');
assert.equal(helpers.cents('-1,234.50'), -123450);
assert.equal(helpers.cents('0.29'), 29);
assert.throws(() => helpers.cents('12x'));
assert.throws(() => helpers.cents('9999999999999999'));
assert.equal(helpers.escape(`<img onerror="x">&'`), '&lt;img onerror=&quot;x&quot;&gt;&amp;&#39;');
const drafts = new Map([['expense:1', {tipe: 'expense', ids: '1', selected: true, tanggal: '2026-11-13', version: 'v1'}],
    ['kasbon:1', {tipe: 'kasbon', ids: '1', selected: true, tanggal: '2026-11-14', version: 'v2'}],
    ['periodik:9', {selected: false}]]);
assert.deepEqual(helpers.requestItems(drafts).map(d => d.tipe), ['expense', 'kasbon']);
drafts.get('kasbon:1').tanggal = '';
assert.throws(() => helpers.requestItems(drafts), /Tanggal/);
assert.throws(() => helpers.requestItems(new Map()), /Pilih/);

function fixture(kind = 'request', detailMode = false, manage = true) {
    const configs = [], requests = [], confirmations = [], notices = [];
    function node(attrs = {}) { return {attrs, cache: {}, handlers: new Map(), children: [], value: '', disabled: false}; }
    const form = node({'data-kind': kind, 'data-base': '/payment/', 'data-manage': manage ? '1' : '0', 'data-token': 'token',
        'data-count': '3', 'data-total': '300.00', 'data-admin': '0', 'data-files-max': '20', 'data-action': detailMode, 'data-back': detailMode ? 'list_approve' : ''});
    const hidden = node({name: 'csrf', type: 'hidden'}); hidden.name = 'csrf'; hidden.value = 'csrf-value';
    const button = node({type: 'submit'}); form.children.push(hidden, button);
    const bank = node({name: 'bank_coa'}); bank.name = 'bank_coa'; bank.value = 'BANK'; form.children.push(bank);
    const tableNode = node(), summary = node(), document = {body: node()};
    const api = {row(collection) { return {data() { return collection[0].rowData; }}; }, ajax: {params() { return {search: {value: ''}, order: []}; }}};
    class Collection {
        constructor(nodes) { this.nodes = nodes; this.length = nodes.length; nodes.forEach((n, i) => { this[i] = n; }); }
        attr(key, value) { if (value === undefined) return this[0] && this[0].attrs[key]; this.nodes.forEach(n => n.attrs[key] = value); return this; }
        data(key, value) { if (value === undefined) return this[0] && this[0].cache[key]; this.nodes.forEach(n => n.cache[key] = value); return this; }
        prop(key, value) { this.nodes.forEach(n => n[key] = value); return this; }
        not(selector) { return new Collection(this.nodes.filter(n => selector !== ':disabled' || !n.disabled)); }
        find(selector) {
            return new Collection(this.nodes.flatMap(n => n.children).filter(n => selector === ':input' ||
                selector === 'input[type="hidden"]' && n.attrs.type === 'hidden' ||
                selector === 'input[type="checkbox"]:checked' && n.attrs.type === 'checkbox' && n.checked));
        }
        each(callback) { this.nodes.forEach((n, i) => callback.call(n, i, n)); return this; }
        on(event, selector, callback) { this.nodes.forEach(n => n.handlers.set(event + ':' + (typeof selector === 'string' ? selector : ''), callback || selector)); return this; }
        text(value) { this.nodes.forEach(n => n.text = value); return this; }
        siblings() { return new Collection([node()]); }
        closest() { return this; }
        DataTable(config) { configs.push(config); return api; }
    }
    function $(arg) {
        if (typeof arg === 'function') { arg(); return; }
        if (typeof arg === 'object') return new Collection([arg]);
        if (arg === '#payment-form') return new Collection(detailMode ? [] : [form]);
        if (arg === '#payment-detail') return new Collection(detailMode ? [form] : []);
        if (arg === '#payment-table') return new Collection([tableNode]);
        if (arg === '#payment-summary') return new Collection([summary]);
        return new Collection([]);
    }
    $.fn = {};
    $.ajax = config => requests.push(config);
    class Data {
        constructor(form) { this.values = new Map(); if (form) form.children.filter(n => n.name && !n.disabled && (n.attrs.type !== 'checkbox' || n.checked)).forEach(n => this.append(n.name, n.value)); }
        append(name, value) { this.values.set(name, value); }
        keys() { return this.values.keys(); }
        delete(key) { this.values.delete(key); }
    }
    const window = {location: {reload() { window.reloaded = true; }}};
    const swal = (config, callback) => { if (typeof config === 'object') confirmations.push(callback); else notices.push(callback); };
    const context = vm.createContext({jQuery: $, window, document, swal, FormData: Data});
    vm.runInContext(source, context);
    function change(row, field, value) {
        const input = node({'data-field': field}); input.rowData = row;
        if (field === 'selected') input.checked = value;
        else if (field === 'file') input.files = value ? [value] : [];
        else input.value = value;
        form.children.push(input);
        form.handlers.get('input.requestPayment change.requestPayment:[data-field]').call(input);
    }
    function submit() { form.handlers.get('submit.requestPayment:')({preventDefault() {}}); }
    return {configs, requests, confirmations, notices, form, button, summary, window, change, submit,
        reloadScript() { vm.runInContext(source, context); }};
}
const request = fixture();
assert.equal(request.configs[0].serverSide, true);
assert.equal(request.configs[0].ajax.type, 'POST');
assert.equal(request.configs[0].columns.length, 9);
assert.deepEqual(Array.from(request.configs[0].lengthMenu), [10, 25, 50, 100]);
const rowA = {key: 'expense:1', tipe: 'expense', ids: '1', no_doc: 'A', jumlah: '100', version: 'v1'};
const rowB = {key: 'kasbon:1', tipe: 'kasbon', ids: '1', no_doc: 'B', jumlah: '200', version: 'v2'};
request.change(rowA, 'selected', true); request.change(rowA, 'tanggal', '2026-11-13');
request.change(rowB, 'selected', true); request.change(rowB, 'tanggal', '2026-11-14');
assert.ok(request.summary.text.startsWith('2 data; total 300.00'));
assert.match(request.configs[0].columns[7].render(rowA), /2026-11-13/);
request.submit(); request.submit(); assert.equal(request.confirmations.length, 1);
request.confirmations.shift()(false); assert.equal(request.button.disabled, false);
request.submit(); request.confirmations.shift()(true); assert.equal(request.requests.length, 1);
assert.deepEqual(JSON.parse(request.requests[0].data.values.get('items')).map(item => item.tipe), ['expense', 'kasbon']);
assert.equal(request.requests[0].data.values.get('csrf'), 'csrf-value');
request.requests[0].error(); assert.equal(request.button.disabled, false);
request.submit(); request.confirmations.shift()(true); request.requests[1].success({save: false, pesan: 'Stale'});
assert.equal(request.button.disabled, false); assert.equal(request.notices.at(-1), 'Stale');
const before = request.form.handlers.size; request.reloadScript();
assert.equal(request.form.handlers.size, before); assert.equal(request.configs.length, 1);
const payment = fixture('payment');
assert.equal(payment.configs[0].columns.length, 12);
const p1 = {key: 'PAY202600001', no_doc: 'P1', jumlah: '100', keterangan: 'Original', bank_admin: '0'};
const file = {name: 'evidence.pdf'};
payment.change(p1, 'bank_admin', '2.50'); payment.change(p1, 'keterangan', 'Changed'); payment.change(p1, 'file', file);
assert.match(payment.configs[0].columns[11].render(p1), /evidence.pdf/);
payment.submit(); payment.confirmations.shift()(true);
assert.equal(payment.requests[0].data.values.get('batch_token'), 'token');
assert.equal(JSON.parse(payment.requests[0].data.values.get('edits')).PAY202600001.bank_admin, '2.50');
assert.equal(payment.requests[0].data.values.get('doc_file_PAY202600001'), file);
payment.requests[0].success({save: true}); assert.equal(payment.window.reloaded, true);
const view = fixture('approval', false, false);
assert.equal(view.configs[0].columns.length, 11);
assert.equal(view.configs[0].columns.at(-1).render({url: '/process'}), '');
const journal = fixture('jurnal'); assert.equal(journal.configs[0].columns.length, 8);
assert.doesNotMatch(journal.configs[0].columns.at(-1).render({url: '/view', edit_url: '/edit', stspos: '1'}), />Edit</);
const detail = fixture('approval', 'save_approval');
const selected = {attrs: {type: 'checkbox'}, name: 'items[8][id]', value: '99', checked: true, disabled: false}; detail.form.children.push(selected);
detail.submit(); detail.confirmations.shift()(true);
assert.equal(detail.requests[0].data.values.get('items[0][id]'), '99');
assert.equal(detail.requests[0].data.values.has('items[8][id]'), false);
detail.requests[0].error(); assert.equal(detail.button.disabled, false);
if (process.env.PAYMENT_TEST_DB === '1') {
    const run = spawnSync('tmp/stock-booking-runtime/php/php.exe', ['-d', 'extension_dir=tmp/stock-booking-runtime/php/ext', '-d', 'extension=mysqli', 'tests/request_payment_test.php'],
        {encoding: 'utf8', env: {...process.env, PAYMENT_RENDER_JSON: '1'}});
    assert.equal(run.status, 0, run.stdout + run.stderr);
    const rendered = JSON.parse(run.stdout.split('\n').find(line => line.startsWith('RENDER_JSON:')).slice('RENDER_JSON:'.length));
    assert.ok(rendered.length >= 7);
    for (const html of rendered) for (const match of html.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/gi)) if (match[1].trim()) new vm.Script(match[1]);
    console.log('PASS: native PHP forms render and scripts parse without browser');
}
console.log('PASS: server-side contracts, drafts across pages, distinct source types, retained files, compact detail arrays, safe rendering, confirmation/duplicate guard and error recovery');
