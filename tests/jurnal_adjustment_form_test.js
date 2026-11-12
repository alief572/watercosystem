// Run: node tests/jurnal_adjustment_form_test.js
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const view = fs.readFileSync(path.join(__dirname, '../application/modules/jurnal_adjustment/views/index.php'), 'utf8');
const script = [...view.matchAll(/<script(?:\s[^>]*)?>([\s\S]*?)<\/script>/g)].map(match => match[1]).join('\n');
const handlers = {}, requests = [], confirmations = [], messages = [];
let disabled = true, tokenPresent = false, reloads = 0, modal = '', errorText = '';
const table = {ajax: {reload() { reloads++; }}};
const $ = selector => ({
    ready(fn) { fn(); },
    on(event, child, fn) { handlers[event + ':' + child] = fn; },
    DataTable() { return table; },
    prop(name, value) { if (selector === '#frm-jurnal :submit' && name === 'disabled') disabled = value; return this; },
    text(value) { errorText = value; return this; },
    empty() { tokenPresent = false; return this; },
    html(value) { tokenPresent = value.includes('preview_token'); return this; },
    attr() { return 'ADJ-TEST'; },
    serialize() { return 'id_transaksi=ADJ-TEST&preview_token=TOKEN'; },
    modal(value) { modal = value; },
    get length() { return selector.includes('input[name="preview_token"]') && tokenPresent ? 1 : 0; }
});
$.ajax = options => {
    const request = {options}; requests.push(request);
    const chain = {};
    for (const name of ['done','fail','always']) chain[name] = fn => { request[name] = fn; return chain; };
    return chain;
};
vm.runInNewContext(script, {
    $, document: {}, siteurl: '/', active_controller: 'jurnal_adjustment/',
    Swal: {fire(options) {
        if (options.showCancelButton) return new Promise(resolve => confirmations.push(resolve));
        messages.push(options); return Promise.resolve({});
    }}
});
const submit = () => handlers['submit:#frm-jurnal']({preventDefault() {}});
function preview(html = '<input name="preview_token">') {
    handlers['click:.process_jurnal'].call({});
    const request = requests.at(-1);
    assert.equal(request.options.type, 'GET'); request.done(html); return request;
}
(async () => {
    await submit(); assert.equal(confirmations.length, 0, 'Submit before preview');
    const first = preview(); assert.equal(disabled, false);
    handlers['click:.process_jurnal'].call({});
    const second = requests.at(-1); first.done('<p>stale</p>');
    assert.equal(disabled, true, 'Old preview response enabled submit');
    second.fail({responseText: '{"msg":"Costbook belum ada"}'});
    assert.equal(errorText, 'Costbook belum ada');
    preview();
    let pending = submit(); await submit();
    assert.equal(confirmations.length, 1); assert.equal(disabled, true);
    confirmations.shift()({isConfirmed: false}); await pending;
    assert.equal(disabled, false, 'Cancel left form disabled');

    pending = submit(); confirmations.shift()({isConfirmed: true}); await pending;
    let request = requests.at(-1); const count = requests.length;
    assert.equal(request.options.type, 'POST');
    assert.equal(request.options.url, '/jurnal_adjustment/save_post_jurnal_adjustment');
    assert.ok(request.options.data.includes('preview_token'));
    await submit(); assert.equal(requests.length, count, 'Duplicate POST');
    request.done({code: 409, msg: 'Sudah diposting'}); request.always();
    assert.equal(messages.at(-1).icon, 'error'); assert.equal(reloads, 0); assert.equal(disabled, true);

    preview(); pending = submit(); confirmations.shift()({isConfirmed: true}); await pending;
    request = requests.at(-1);
    request.fail({responseJSON: {msg: 'Posting belum terkonfirmasi'}}); request.always();
    assert.equal(disabled, true); assert.ok(messages.at(-1).text.includes('Posting belum terkonfirmasi'));

    preview(); pending = submit(); confirmations.shift()({isConfirmed: true}); await pending;
    request = requests.at(-1); request.done({code: 200, msg: 'Berhasil', nomor: '101-AJV2600101'}); request.always();
    assert.equal(messages.at(-1).icon, 'success'); assert.equal(reloads, 1); assert.equal(modal, 'hide');
    assert.equal(disabled, true);
    console.log('PASS: preview race/error, token, confirmation cancel, duplicate submit, failure recovery, success response');
})().catch(error => { console.error(error); process.exitCode = 1; });
