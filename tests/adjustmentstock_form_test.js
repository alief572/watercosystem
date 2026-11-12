// Run: node tests/adjustmentstock_form_test.js [path/to/php]
const assert = require('node:assert/strict');
const { execFileSync } = require('node:child_process');
const path = require('node:path');
const vm = require('node:vm');

const script = execFileSync(process.argv[2] || 'php', ['-n', '-r',
    'ob_start(); require $argv[1]; ob_end_clean(); preg_match("~<script[^>]*>(.*)</script>~s", $html, $parts); echo $parts[1];',
    path.join(__dirname, 'adjustmentstock_view_test.php')], { encoding: 'utf8' });
let submit, disabled = false, requests = 0;
const confirmations = [], callbacks = {}, location = { href: '' };
const $ = selector => ({
    on(event, handler) { assert.equal(event, 'submit'); submit = handler; },
    prop(name, value) { assert.equal(name, 'disabled'); disabled = value; }
});
$.ajax = options => {
    requests++;
    assert.equal(options.type, 'POST');
    assert.equal(options.url, '/adjustmentstockmulti/SavePlus');
    const chain = {};
    for (const name of ['done', 'fail', 'always']) { chain[name] = fn => { callbacks[name] = fn; return chain; }; }
    return chain;
};
vm.runInNewContext(script, {
    $, window: { location }, FormData: class {},
    swal(options, callback) { if (typeof options === 'object') { confirmations.push(callback); } }
});
const form = { reportValidity: () => true };
const event = { preventDefault() {} };
submit.call({ reportValidity: () => false }, event);
assert.equal(confirmations.length, 0);
submit.call(form, event);
submit.call(form, event);
assert.equal(confirmations.length, 1);
assert.equal(disabled, true);
confirmations.shift()(false);
assert.equal(disabled, false);
submit.call(form, event);
confirmations.shift()(true);
submit.call(form, event);
assert.equal(requests, 1);
assert.equal(confirmations.length, 0);
callbacks.done({ status: 0, pesan: 'Ditolak' }); callbacks.always();
assert.equal(disabled, false);
submit.call(form, event); confirmations.shift()(true);
callbacks.fail(); callbacks.always();
assert.equal(disabled, false);
submit.call(form, event); confirmations.shift()(true);
callbacks.done({ status: 1 }); callbacks.always();
assert.equal(requests, 3);
assert.equal(location.href, '/adjustmentstockmulti/mutasi');
console.log('PASS: form validation, cancel, duplicate-submit guard, failure recovery and redirect');
