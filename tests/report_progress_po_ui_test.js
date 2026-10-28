const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

let options, request;
const handlers = [];
function element(selector) {
    let text = '';
    const el = {
        length: 1,
        attr(name) { return name === 'data-url' ? '/report_progress_po' : el; },
        serializeArray() { return [{ name: 'start_date', value: '2026-01-01' }, { name: 'end_date', value: '2026-10-26' }]; },
        text(value) { text = String(value); return el; },
        html() { return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); },
        on(event, target, callback) { handlers.push({ selector, event, target, callback }); return el; },
        find() { return element('found'); },
        prop() { return el; },
        DataTable(config) { options = config; return { ajax: { reload() {} }, columns: { adjust() {} } }; }
    };
    return el;
}
function $(value) { if (typeof value === 'function') { value(); return; } return element(value); }
$.each = (values, callback) => values.forEach((value, index) => callback(index, value));
$.extend = Object.assign;
$.ajax = (input) => {
    request = input;
    const chain = { abort() {}, done() { return chain; }, fail() { return chain; } };
    return chain;
};
vm.runInNewContext(fs.readFileSync('assets/js/report_progress_po.js', 'utf8'), { jQuery: $, Intl, console });
const po = { number: '<img src=x onerror=alert(1)>', date: '2026-10-26', supplier: '<script>alert(1)</script>',
    type: 'Import', currency: 'USD', progress: 40, status: 'Sebagian Diterima', status_code: 'parsial', closed: false, issues: [], last_incoming: '2026-11-01' };
assert.equal(options.columns.length, 9);
assert.match(options.columns[0].render(po.date, 'display', po), /&lt;img/);
assert.doesNotMatch(options.columns[1].render(po.supplier, 'display', po), /<script>/);
assert.match(options.columns[2].render(40, 'display', po), /width:40%/);
assert.match(options.columns[2].render(40, 'display', po), /Sebagian Diterima/);
assert.match(options.columns[2].render(150, 'display', { ...po, progress: 150 }), /width:100%/);
assert.doesNotMatch(options.columns[2].render(null, 'display', { ...po, progress: null }), /po-progress-fill/);
assert.doesNotMatch(options.columns[2].render(null, 'display', { ...po, status_code: '"><script>', status: '<script>' }), /<script>/);
assert.equal(options.columns[4].render(null), '-');
assert.equal(options.columns[4].render('<script>'), '-');
assert.match(options.columns[3].render(10000, 'display', po), /US\$ 10\.000/);
assert.match(options.columns[7].render(null, 'display', po), /Belum ada Incoming/);
assert.match(options.columns[7].render('2026-10-01', 'display', po), /s\.d\./);
assert.doesNotMatch(options.columns[8].render(null, 'display', po), /<img/);
console.log('PASS: nine PO columns, localized values, safe text, real progress, and missing-data states');

const fields = ['date', 'supplier', 'progress', 'native', 'total_idr', 'received_idr', 'remaining_idr'];
fields.forEach((field, index) => {
    options.ajax({ order: [{ column: index, dir: 'asc' }], start: 0, length: 25, draw: 1 }, () => {});
    assert.equal(request.data.sort, field);
    assert.equal(request.data.start_date, '2026-01-01');
    assert.equal(request.data.direction, 'asc');
});
assert.ok(handlers.some(item => item.event === 'keydown'));
assert.ok(handlers.some(item => item.target === '#po-show-problems'));
assert.ok(handlers.some(item => item.target === '#po-retry'));
assert.ok(handlers.some(item => item.event === 'input change'));
console.log('PASS: regrouped columns preserve server sort/filter contracts; keyboard, retry and pending-filter handlers registered');
