<?php
/**
 * Adversarial Stress Test: Error Reporting & Error Handling Pipeline Under PHP 8.5
 * Target Runtime: PHP 8.5.12 inside waterco_web85
 *
 * Verifies:
 * 1. index.php ENVIRONMENT switch error_reporting levels across:
 *    - development: 6143 (E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED), display_errors = 1
 *    - testing:     5111, display_errors = 0 (MUST NOT BE 0)
 *    - production:  5111, display_errors = 0 (MUST NOT BE 0)
 * 2. PHP 8.5 bitmask integrity:
 *    - E_STRICT constant deprecation avoidance ($strict evaluates to ~0 without triggering deprecation)
 *    - Full bit-by-bit breakdown of 5111 against all PHP error constants
 * 3. CodeIgniter 3 _error_handler integration:
 *    - E_USER_WARNING (512) captured by CI error handler and logged
 *    - E_USER_ERROR (256) captured by CI error handler, logged, and triggers exit(1)
 *    - E_USER_NOTICE (1024) and E_USER_DEPRECATED (16384) silenced as expected in production
 *    - Real end-to-end CI3 logging verification in application/logs/
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

class Term
{
    public static function color(string $text, string $color): string
    {
        $codes = [
            'reset'  => "\033[0m",
            'bold'   => "\033[1m",
            'red'    => "\033[31m",
            'green'  => "\033[32m",
            'yellow' => "\033[33m",
            'cyan'   => "\033[36m",
        ];
        return ($codes[$color] ?? '') . $text . ($codes['reset'] ?? '');
    }
}

$totalAssertions = 0;
$totalPassed = 0;
$totalFailed = 0;
$vulnerabilities = [];

function assert_true(bool $condition, string $description, ?string $failureDetail = null)
{
    global $totalAssertions, $totalPassed, $totalFailed, $vulnerabilities;
    $totalAssertions++;
    if ($condition) {
        $totalPassed++;
        echo "  " . Term::color("[PASS]", 'green') . " {$description}\n";
    } else {
        $totalFailed++;
        $msg = "  " . Term::color("[FAIL]", 'red') . " {$description}";
        if ($failureDetail) {
            $msg .= " -> {$failureDetail}";
        }
        echo "{$msg}\n";
        $vulnerabilities[] = $description . ($failureDetail ? " ({$failureDetail})" : "");
    }
}

echo Term::color("===================================================================\n", 'cyan');
echo Term::color(" ADVERSARIAL STRESS TEST: ERROR REPORTING & ERROR HANDLER (PHP 8.5)\n", 'bold');
echo Term::color("===================================================================\n", 'cyan');
echo "Runtime PHP: " . PHP_VERSION . " (ID: " . PHP_VERSION_ID . ")\n\n";

// =============================================================================
// SUITE 1: BITMASK ARITHMETIC & E_STRICT DEPRECATION AVOIDANCE
// =============================================================================
echo Term::color("--- SUITE 1: BITMASK ARITHMETIC & PHP 8.5 CONSTANT BREAKDOWN ---\n", 'bold');

// Verify PHP 8.5 E_ALL value
$expected_E_ALL = 30719; // In PHP 8.4+, E_STRICT (2048) was removed from E_ALL
assert_true(
    E_ALL === $expected_E_ALL,
    "PHP 8.5 E_ALL value matches 30719 (2048 E_STRICT removed)",
    "Actual: " . E_ALL
);

// Verify $strict evaluation logic in index.php without triggering deprecation
$strictTrap = [];
set_error_handler(function ($errno, $errstr) use (&$strictTrap) {
    $strictTrap[] = ['errno' => $errno, 'message' => $errstr];
    return true;
}, E_ALL);

$strict_eval = (PHP_VERSION_ID < 80400 && defined('E_STRICT')) ? ~E_STRICT : ~0;
restore_error_handler();

assert_true(
    empty($strictTrap),
    "Evaluating index.php \$strict condition triggers ZERO deprecations in PHP 8.5",
    "Deprecations triggered: " . count($strictTrap)
);

assert_true(
    $strict_eval === ~0,
    "index.php \$strict evaluates to ~0 (-1 all bits set) in PHP 8.5.12",
    "Actual strict: " . var_export($strict_eval, true)
);

// Verify exact bitmask calculation for testing and production
$calc_test_prod = (E_ALL & ~E_NOTICE & ~E_DEPRECATED & $strict_eval & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
assert_true(
    $calc_test_prod === 5111,
    "Calculated testing/production bitmask equals exactly 5111",
    "Actual calculated: {$calc_test_prod}"
);

// Verify individual bit status in 5111
$bitChecks = [
    'E_ERROR (1)'                 => [E_ERROR, true],
    'E_WARNING (2)'               => [E_WARNING, true],
    'E_PARSE (4)'                 => [E_PARSE, true],
    'E_NOTICE (8)'                => [E_NOTICE, false],
    'E_CORE_ERROR (16)'           => [E_CORE_ERROR, true],
    'E_CORE_WARNING (32)'         => [E_CORE_WARNING, true],
    'E_COMPILE_ERROR (64)'        => [E_COMPILE_ERROR, true],
    'E_COMPILE_WARNING (128)'     => [E_COMPILE_WARNING, true],
    'E_USER_ERROR (256)'          => [E_USER_ERROR, true],
    'E_USER_WARNING (512)'        => [E_USER_WARNING, true],
    'E_USER_NOTICE (1024)'        => [E_USER_NOTICE, false],
    'E_RECOVERABLE_ERROR (4096)'  => [E_RECOVERABLE_ERROR, true],
    'E_DEPRECATED (8192)'         => [E_DEPRECATED, false],
    'E_USER_DEPRECATED (16384)'   => [E_USER_DEPRECATED, false],
];

foreach ($bitChecks as $name => [$bitVal, $expectedSet]) {
    $isSet = (($calc_test_prod & $bitVal) === $bitVal);
    assert_true(
        $isSet === $expectedSet,
        "Bitmask 5111 " . ($expectedSet ? "INCLUDES " : "EXCLUDES ") . $name,
        "Bitmask & bitVal = " . ($calc_test_prod & $bitVal)
    );
}

// =============================================================================
// SUITE 2: SUBPROCESS ENVIRONMENT SIMULATION (index.php Exact Logic)
// =============================================================================
echo "\n" . Term::color("--- SUITE 2: ENVIRONMENT SIMULATION ACROSS ENVIRONMENTS ---\n", 'bold');

$environments = ['development', 'testing', 'production'];

foreach ($environments as $env) {
    // Run an isolated PHP subprocess to test the exact index.php logic
    $cmd = sprintf(
        'php -r %s',
        escapeshellarg(
            '$_SERVER["CI_ENV"] = "' . $env . '";' .
            'define("ENVIRONMENT", isset($_SERVER["CI_ENV"]) ? $_SERVER["CI_ENV"] : "development");' .
            'switch (ENVIRONMENT) {' .
            '    case "development":' .
            '        error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);' .
            '        ini_set("display_errors", 1);' .
            '        break;' .
            '    case "testing":' .
            '    case "production":' .
            '        ini_set("display_errors", 0);' .
            '        $strict = (PHP_VERSION_ID < 80400 && defined("E_STRICT")) ? ~E_STRICT : ~0;' .
            '        if (version_compare(PHP_VERSION, "5.3", ">=")) {' .
            '            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & $strict & ~E_USER_NOTICE & ~E_USER_DEPRECATED);' .
            '        } else {' .
            '            error_reporting(E_ALL & ~E_NOTICE & $strict & ~E_USER_NOTICE);' .
            '        }' .
            '        break;' .
            '}' .
            'echo json_encode([' .
            '    "env" => ENVIRONMENT,' .
            '    "error_reporting" => error_reporting(),' .
            '    "display_errors" => ini_get("display_errors")' .
            ']);'
        )
    );

    $out = shell_exec($cmd);
    $data = json_decode($out, true);

    assert_true(
        is_array($data) && isset($data['env']) && $data['env'] === $env,
        "Subprocess executed environment '{$env}' cleanly",
        "Raw: {$out}"
    );

    if ($env === 'development') {
        // In development, error_reporting is E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED = 6143
        $expectedReporting = 30719 & ~8192 & ~16384; // 6143
        assert_true(
            $data['error_reporting'] === $expectedReporting,
            "Environment '{$env}': error_reporting is {$expectedReporting} (not silenced)",
            "Got: " . ($data['error_reporting'] ?? 'null')
        );
        assert_true(
            $data['display_errors'] === '1',
            "Environment '{$env}': display_errors is '1'",
            "Got: " . ($data['display_errors'] ?? 'null')
        );
    } else {
        // In testing and production, error_reporting must be 5111 and NEVER 0
        assert_true(
            $data['error_reporting'] === 5111,
            "Environment '{$env}': error_reporting is 5111",
            "Got: " . ($data['error_reporting'] ?? 'null')
        );
        assert_true(
            $data['error_reporting'] !== 0,
            "Environment '{$env}': error_reporting is NOT 0 (Zero silencing bug fixed)",
            "Got: " . ($data['error_reporting'] ?? 'null')
        );
        assert_true(
            $data['display_errors'] === '0',
            "Environment '{$env}': display_errors is '0' (Errors suppressed from HTTP output)",
            "Got: " . ($data['display_errors'] ?? 'null')
        );
    }
}

// =============================================================================
// SUITE 3: CODEIGNITER _error_handler ERROR CAPTURE & SEVERITY FILTERING
// =============================================================================
echo "\n" . Term::color("--- SUITE 3: CI3 _error_handler CAPTURE & FILTERING PIPELINE ---\n", 'bold');

// Test 3.1: Verify severity condition from system/core/Common.php:613
// if (($severity & error_reporting()) !== $severity) { return; }
$testSeverities = [
    'E_USER_WARNING (512)'     => [E_USER_WARNING, true,  'E_USER_WARNING must pass filter and be logged'],
    'E_USER_ERROR (256)'       => [E_USER_ERROR,   true,  'E_USER_ERROR must pass filter and be logged'],
    'E_WARNING (2)'            => [E_WARNING,      true,  'E_WARNING must pass filter and be logged'],
    'E_ERROR (1)'              => [E_ERROR,        true,  'E_ERROR must pass filter and be logged'],
    'E_USER_NOTICE (1024)'     => [E_USER_NOTICE,  false, 'E_USER_NOTICE must be filtered out / silenced'],
    'E_NOTICE (8)'             => [E_NOTICE,       false, 'E_NOTICE must be filtered out / silenced'],
    'E_USER_DEPRECATED (16384)'=> [E_USER_DEPRECATED, false, 'E_USER_DEPRECATED must be filtered out / silenced'],
    'E_DEPRECATED (8192)'      => [E_DEPRECATED,   false, 'E_DEPRECATED must be filtered out / silenced'],
];

error_reporting(5111);
ini_set('display_errors', '0');

foreach ($testSeverities as $label => [$sev, $shouldPass, $desc]) {
    $passes = (($sev & error_reporting()) === $sev);
    assert_true(
        $passes === $shouldPass,
        "CI3 filter for {$label}: " . ($shouldPass ? "PASSES (logged)" : "REJECTS (silenced)"),
        "severity & error_reporting = " . ($sev & error_reporting())
    );
}

// Test 3.2: Subprocess execution of trigger_error(E_USER_WARNING) under production
$warningScript = escapeshellarg(
    'error_reporting(5111);' .
    'ini_set("display_errors", "0");' .
    '$logged = false;' .
    'set_error_handler(function($severity, $message, $file, $line) use (&$logged) {' .
    '    if (($severity & error_reporting()) === $severity) {' .
    '        $logged = true;' .
    '    }' .
    '    return true;' .
    '});' .
    'trigger_error("Adversarial Warning Test", E_USER_WARNING);' .
    'echo json_encode(["logged" => $logged]);'
);
$resWarning = shell_exec("php -r {$warningScript}");
$dataWarning = json_decode($resWarning, true);
assert_true(
    isset($dataWarning['logged']) && $dataWarning['logged'] === true,
    "trigger_error(E_USER_WARNING) captured by error handler under error_reporting=5111",
    "Result: {$resWarning}"
);

// Test 3.3: Subprocess execution of trigger_error(E_USER_ERROR) under production
// Note: In PHP 8.4+, trigger_error(..., E_USER_ERROR) first emits E_DEPRECATED (8192),
// then emits E_USER_ERROR (256). The CI handler filters 8192 and executes 256 then exits(1).
$errorScript = escapeshellarg(
    'error_reporting(5111);' .
    'ini_set("display_errors", "0");' .
    'set_error_handler(function($severity, $message, $file, $line) {' .
    '    $is_error = (((E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);' .
    '    if (($severity & error_reporting()) !== $severity) {' .
    '        return true;' .
    '    }' .
    '    file_put_contents("/tmp/adv_user_error_test.txt", "CAPTURED:" . $severity);' .
    '    if ($is_error) {' .
    '        exit(1);' .
    '    }' .
    '    return true;' .
    '});' .
    'trigger_error("Adversarial User Error Test", E_USER_ERROR);'
);
@unlink('/tmp/adv_user_error_test.txt');
$proc = proc_open("php -r {$errorScript}", [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
], $pipes);

$outErr = stream_get_contents($pipes[1]);
$errErr = stream_get_contents($pipes[2]);
fclose($pipes[0]);
fclose($pipes[1]);
fclose($pipes[2]);
$exitCode = proc_close($proc);

$capturedContent = file_exists('/tmp/adv_user_error_test.txt') ? file_get_contents('/tmp/adv_user_error_test.txt') : '';
@unlink('/tmp/adv_user_error_test.txt');

assert_true(
    $exitCode === 1,
    "trigger_error(E_USER_ERROR) halts execution with exit code 1",
    "Exit code: {$exitCode}"
);
assert_true(
    $capturedContent === 'CAPTURED:256',
    "trigger_error(E_USER_ERROR) severity 256 passed error_reporting(5111) filter before halt",
    "Captured content: '{$capturedContent}'"
);

// Test 3.4: Subprocess verification that E_USER_NOTICE is silenced under production
$noticeScript = escapeshellarg(
    'error_reporting(5111);' .
    'ini_set("display_errors", "0");' .
    '$passedFilter = false;' .
    'set_error_handler(function($severity, $message, $file, $line) use (&$passedFilter) {' .
    '    if (($severity & error_reporting()) === $severity) {' .
    '        $passedFilter = true;' .
    '    }' .
    '    return true;' .
    '});' .
    'trigger_error("Adversarial User Notice Test", E_USER_NOTICE);' .
    'echo json_encode(["passedFilter" => $passedFilter]);'
);
$resNotice = shell_exec("php -r {$noticeScript}");
$dataNotice = json_decode($resNotice, true);
assert_true(
    isset($dataNotice['passedFilter']) && $dataNotice['passedFilter'] === false,
    "trigger_error(E_USER_NOTICE) is correctly silenced by error_reporting=5111 (not logged)",
    "Result: {$resNotice}"
);

// =============================================================================
// SUITE 4: REAL END-TO-END CI3 LOGGER INTEGRATION TEST
// =============================================================================
echo "\n" . Term::color("--- SUITE 4: REAL END-TO-END CI3 LOGGER INTEGRATION TEST ---\n", 'bold');

$testTokenWarn = 'ADV_WARN_TOKEN_' . bin2hex(random_bytes(6));
$testTokenErr  = 'ADV_ERR_TOKEN_' . bin2hex(random_bytes(6));

// Step 4.1: Run a full CI3 bootstrap script that fires E_USER_WARNING with $testTokenWarn
$realWarnScript = escapeshellarg(
    '$_SERVER["HTTP_HOST"] = "localhost";' .
    '$_SERVER["REQUEST_URI"] = "/";' .
    '$_SERVER["REMOTE_ADDR"] = "127.0.0.1";' .
    '$_SERVER["REQUEST_METHOD"] = "GET";' .
    'define("BASEPATH", "/var/www/html/system/");' .
    'define("APPPATH", "/var/www/html/application/");' .
    'define("VIEWPATH", "/var/www/html/application/views/");' .
    'define("FCPATH", "/var/www/html/");' .
    'define("ENVIRONMENT", "production");' .
    'require_once BASEPATH . "core/Common.php";' .
    'error_reporting(5111);' .
    'ini_set("display_errors", "0");' .
    'set_error_handler("_error_handler");' .
    'trigger_error("' . $testTokenWarn . '", E_USER_WARNING);' .
    'echo "DONE_WARN";'
);
$resRealWarn = shell_exec("php -r {$realWarnScript}");
assert_true(
    trim($resRealWarn) === 'DONE_WARN',
    "CI3 real _error_handler executed E_USER_WARNING and resumed script execution cleanly",
    "Output: '{$resRealWarn}'"
);

// Step 4.2: Verify $testTokenWarn was appended to application/logs/log-<date>.php
$logFilePath = '/var/www/html/application/logs/log-' . date('Y-m-d') . '.php';
$logContent = file_exists($logFilePath) ? file_get_contents($logFilePath) : '';
assert_true(
    strpos($logContent, $testTokenWarn) !== false,
    "E_USER_WARNING token '{$testTokenWarn}' was captured and written to CI log file ({$logFilePath})"
);
assert_true(
    strpos($logContent, 'Severity: User Warning --> ' . $testTokenWarn) !== false,
    "Log file contains exact formatted string 'Severity: User Warning --> {$testTokenWarn}'"
);

// Step 4.3: Run a full CI3 bootstrap script that fires E_USER_ERROR with $testTokenErr
$realErrScript = escapeshellarg(
    '$_SERVER["HTTP_HOST"] = "localhost";' .
    '$_SERVER["REQUEST_URI"] = "/";' .
    '$_SERVER["REMOTE_ADDR"] = "127.0.0.1";' .
    '$_SERVER["REQUEST_METHOD"] = "GET";' .
    'define("BASEPATH", "/var/www/html/system/");' .
    'define("APPPATH", "/var/www/html/application/");' .
    'define("VIEWPATH", "/var/www/html/application/views/");' .
    'define("FCPATH", "/var/www/html/");' .
    'define("ENVIRONMENT", "production");' .
    'require_once BASEPATH . "core/Common.php";' .
    'error_reporting(5111);' .
    'ini_set("display_errors", "0");' .
    'set_error_handler("_error_handler");' .
    'trigger_error("' . $testTokenErr . '", E_USER_ERROR);' .
    'echo "SHOULD_NOT_REACH_HERE";'
);
$procRealErr = proc_open("php -r {$realErrScript}", [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
], $pipesRealErr);

$outRealErr = stream_get_contents($pipesRealErr[1]);
$errRealErr = stream_get_contents($pipesRealErr[2]);
fclose($pipesRealErr[0]);
fclose($pipesRealErr[1]);
fclose($pipesRealErr[2]);
$exitCodeRealErr = proc_close($procRealErr);

assert_true(
    $exitCodeRealErr === 1,
    "CI3 real _error_handler halted script with exit code 1 upon E_USER_ERROR",
    "Exit code: {$exitCodeRealErr}, Out: {$outRealErr}"
);

// Step 4.4: Verify $testTokenErr was appended to application/logs/
$logContentUpdated = file_exists($logFilePath) ? file_get_contents($logFilePath) : '';
assert_true(
    strpos($logContentUpdated, $testTokenErr) !== false,
    "E_USER_ERROR token '{$testTokenErr}' was captured and written to CI log file ({$logFilePath})"
);
assert_true(
    strpos($logContentUpdated, 'Severity: User Error --> ' . $testTokenErr) !== false,
    "Log file contains exact formatted string 'Severity: User Error --> {$testTokenErr}'"
);

// =============================================================================
// SUMMARY & VERDICT
// =============================================================================
echo "\n" . Term::color("===================================================================\n", 'cyan');
echo Term::color(" TEST SUMMARY\n", 'bold');
echo "  Total Assertions : {$totalAssertions}\n";
echo "  Passed           : " . Term::color("{$totalPassed}", 'green') . "\n";
echo "  Failed           : " . ($totalFailed > 0 ? Term::color("{$totalFailed}", 'red') : "0") . "\n";

if ($totalFailed === 0) {
    echo "\n" . Term::color(">>> VERDICT: APPROVE <<<", 'green') . "\n";
    exit(0);
} else {
    echo "\n" . Term::color(">>> VERDICT: CHALLENGE_FAILED <<<", 'red') . "\n";
    echo "Identified Vulnerabilities:\n";
    foreach ($vulnerabilities as $v) {
        echo "  - {$v}\n";
    }
    exit(1);
}
