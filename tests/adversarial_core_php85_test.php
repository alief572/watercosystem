<?php
/**
 * Adversarial Empirical Stress Test Suite for Milestone 1 (PHP 8.5 Core Upgrades)
 *
 * Verifies:
 * 1. CI_Exceptions: E_STRICT constant safety, $levels array integrity, error formatting.
 * 2. Session: _configure_sid_length() under PHP 8.5, sid_regexp validation, INI deprecation safety.
 * 3. CI_DB_mysqli_driver: reconnect() with active, closed, killed, and null connections. No mysqli::ping().
 * 4. Dynamic properties: #[\AllowDynamicProperties] coverage on core base classes.
 * 5. HTTP smoke test: Live login and authenticated dashboard access.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit("CLI only\n");
}

$baseDir = dirname(__DIR__);
define('BASEPATH', $baseDir . '/system/');
define('APPPATH', $baseDir . '/application/');
define('VIEWPATH', $baseDir . '/application/views/');
define('FCPATH', $baseDir . '/');
define('ENVIRONMENT', 'development');

// Setup mock server globals for CLI
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';

require_once BASEPATH . 'core/Common.php';
get_config(['log_path' => '', 'log_threshold' => 0, 'error_views_path' => VIEWPATH . 'errors/']);

// ------------------------------------------------------------------------
// STRICT ERROR TRAP
// ------------------------------------------------------------------------
error_reporting(-1);
ini_set('display_errors', '1');

$captured_errors = [];
set_error_handler(function ($severity, $message, $file, $line) {
    global $captured_errors;
    $captured_errors[] = [
        'severity' => $severity,
        'message'  => $message,
        'file'     => $file,
        'line'     => $line
    ];
    // Fail immediately on any unsuppressed deprecation, warning, or notice
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

echo "=== ADVERSARIAL STRESS TEST SUITE: PHP 8.5 CORE (M1) ===\n";
echo "PHP Version: " . PHP_VERSION . " (ID: " . PHP_VERSION_ID . ")\n\n";

$passCount = 0;
$failCount = 0;

function assert_test($description, $condition, $detail = '') {
    global $passCount, $failCount;
    if ($condition) {
        echo "  [PASS] $description\n";
        $passCount++;
    } else {
        echo "  [FAIL] $description: $detail\n";
        $failCount++;
    }
}

// ========================================================================
// 1. STRESS TEST: CI_Exceptions
// ========================================================================
echo "[TEST SUITE 1: CI_Exceptions in PHP 8.5.12]\n";

try {
    require_once BASEPATH . 'core/Exceptions.php';
    $exc = new CI_Exceptions();
    assert_test("CI_Exceptions instantiated cleanly without error", $exc instanceof CI_Exceptions);
} catch (\Throwable $e) {
    assert_test("CI_Exceptions instantiated cleanly without error", false, $e->getMessage());
}

// Verify E_STRICT is NOT present in $levels under PHP 8.5
assert_test(
    "E_STRICT (2048) is NOT registered in CI_Exceptions::\$levels under PHP 8.5+",
    !isset($exc->levels[2048]) && !array_key_exists(2048, $exc->levels)
);

// Verify standard error levels are present
$expectedLevels = [
    E_ERROR => 'Error',
    E_WARNING => 'Warning',
    E_PARSE => 'Parsing Error',
    E_NOTICE => 'Notice',
    E_USER_ERROR => 'User Error',
    E_USER_WARNING => 'User Warning',
    E_USER_NOTICE => 'User Notice'
];
$levelsOk = true;
foreach ($expectedLevels as $code => $label) {
    if (!isset($exc->levels[$code]) || $exc->levels[$code] !== $label) {
        $levelsOk = false;
        break;
    }
}
assert_test("Standard PHP error severity mapping is intact in \$levels", $levelsOk);

// Trigger simulated user notices and verify formatting
try {
    ob_start();
    $exc->show_php_error(E_USER_NOTICE, 'Simulated adversarial user notice', __FILE__, 123);
    $outputNotice = ob_get_clean();
    $noticeFormatted = (strpos($outputNotice, 'User Notice') !== false && strpos($outputNotice, 'Simulated adversarial user notice') !== false);
    assert_test("show_php_error(E_USER_NOTICE) formats CLI error with correct severity", $noticeFormatted, substr($outputNotice, 0, 100));
} catch (\Throwable $e) {
    ob_end_clean();
    assert_test("show_php_error(E_USER_NOTICE) formats CLI error with correct severity", false, $e->getMessage());
}

try {
    ob_start();
    $exc->show_php_error(E_USER_WARNING, 'Simulated adversarial user warning', __FILE__, 124);
    $outputWarning = ob_get_clean();
    $warningFormatted = (strpos($outputWarning, 'User Warning') !== false && strpos($outputWarning, 'Simulated adversarial user warning') !== false);
    assert_test("show_php_error(E_USER_WARNING) formats CLI error with correct severity", $warningFormatted, substr($outputWarning, 0, 100));
} catch (\Throwable $e) {
    ob_end_clean();
    assert_test("show_php_error(E_USER_WARNING) formats CLI error with correct severity", false, $e->getMessage());
}

// Test unregistered error severity (e.g. E_USER_DEPRECATED)
try {
    ob_start();
    $exc->show_php_error(E_USER_DEPRECATED, 'Simulated adversarial user deprecation', __FILE__, 125);
    $outputDeprec = ob_get_clean();
    $deprecFormatted = (strpos($outputDeprec, 'Simulated adversarial user deprecation') !== false);
    assert_test("show_php_error(E_USER_DEPRECATED) handles unregistered severity gracefully", $deprecFormatted);
} catch (\Throwable $e) {
    ob_end_clean();
    assert_test("show_php_error(E_USER_DEPRECATED) handles unregistered severity gracefully", false, $e->getMessage());
}

echo "\n";

// ========================================================================
// 2. STRESS TEST: Session::_configure_sid_length()
// ========================================================================
echo "[TEST SUITE 2: Session _configure_sid_length() in PHP 8.5.12]\n";

require_once BASEPATH . 'libraries/Session/Session.php';

// Concrete subclass exposing protected methods for empirical stress testing
class Testable_Session extends CI_Session {
    public function __construct() {
        // Do not invoke parent::__construct to avoid session_start() in CLI
    }
    public function call_configure_sid_length() {
        return $this->_configure_sid_length();
    }
    public function get_sid_regexp() {
        return $this->_sid_regexp;
    }
    public function set_sid_regexp($regexp) {
        $this->_sid_regexp = $regexp;
    }
}

$sessionTest = new Testable_Session();

// Verify via isolated subprocess that raw ini_set('session.sid_length') triggers deprecation in PHP 8.5
$rawDeprecOutput = shell_exec('php -r "error_reporting(E_ALL); ini_set(\'display_errors\', \'1\'); ini_set(\'session.sid_length\', \'48\');" 2>&1');
$testIniDeprecConfirmed = (strpos($rawDeprecOutput, 'session.sid_length INI setting is deprecated') !== false);

assert_test(
    "PHP 8.5 natively deprecates ini_set('session.sid_length') [Deprecation trap confirmed]",
    $testIniDeprecConfirmed,
    "Output: $rawDeprecOutput"
);

// Now execute _configure_sid_length() with strict error trap active
try {
    $sessionTest->call_configure_sid_length();
    $sidRegexp = $sessionTest->get_sid_regexp();
    assert_test(
        "_configure_sid_length() executes cleanly without emitting session.sid_length deprecation",
        !empty($sidRegexp)
    );
    assert_test(
        "_sid_regexp generated pattern matches standard 32-char hex session ID",
        preg_match('#\A' . $sidRegexp . '\z#', bin2hex(random_bytes(16))) === 1,
        "Generated regexp: $sidRegexp"
    );
    // Adversarial reject tests
    assert_test("Regexp rejects short session ID (16 chars)", preg_match('#\A' . $sidRegexp . '\z#', '0123456789abcdef') === 0);
    assert_test("Regexp rejects path traversal attack", preg_match('#\A' . $sidRegexp . '\z#', '../../etc/passwd') === 0);
    assert_test("Regexp rejects SQL injection payload", preg_match('#\A' . $sidRegexp . '\z#', "' OR '1'='1' -- ") === 0);
    assert_test("Regexp rejects non-hex characters for bits=4", preg_match('#\A' . $sidRegexp . '\z#', str_repeat('z', 32)) === 0);
} catch (\Throwable $e) {
    assert_test("_configure_sid_length() executes cleanly", false, $e->getMessage());
}

echo "\n";

// ========================================================================
// 3. STRESS TEST: CI_DB_mysqli_driver::reconnect()
// ========================================================================
echo "[TEST SUITE 3: CI_DB_mysqli_driver::reconnect() in PHP 8.5.12]\n";

require_once BASEPATH . 'database/DB_driver.php';
require_once BASEPATH . 'database/DB_query_builder.php';
if (!class_exists('CI_DB', false)) {
    class CI_DB extends CI_DB_query_builder {}
}
require_once BASEPATH . 'database/drivers/mysqli/mysqli_driver.php';

$dbHost = getenv('DB_HOST') ?: 'db';
$dbUser = getenv('DB_USER') ?: 'alief';
$dbPass = getenv('DB_PASS') ?: 'sdk*^HkfJKjkefJFJLEJLE';
$dbName = getenv('DB_NAME') ?: 'waterco_demo';
$dbPort = (int) (getenv('DB_PORT') ?: 3306);

$dbConfig = [
    'dbdriver' => 'mysqli',
    'hostname' => $dbHost,
    'username' => $dbUser,
    'password' => $dbPass,
    'database' => $dbName,
    'port'     => $dbPort,
    'pconnect' => false,
    'db_debug' => true,
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
];

// Test 3.1: Live active connection reconnect()
$db = null;
try {
    $db = new CI_DB_mysqli_driver($dbConfig);
    $db->initialize();
    
    assert_test("CI_DB_mysqli_driver connected to $dbHost:$dbPort/$dbName", $db->conn_id instanceof \mysqli);
    
    // Call reconnect() on healthy live connection
    $db->reconnect();
    assert_test("reconnect() on healthy connection preserves valid mysqli conn_id", $db->conn_id instanceof \mysqli);
    
    // Verify SELECT 1 left the connection in a clean state (no commands out of sync)
    $res = $db->conn_id->query("SELECT 2 + 3 AS calc");
    $row = $res ? $res->fetch_assoc() : null;
    assert_test("Post-reconnect query executes cleanly (wire state in sync)", $row && (int)$row['calc'] === 5);
    if ($res instanceof \mysqli_result) {
        $res->free();
    }
} catch (\Throwable $e) {
    assert_test("reconnect() on healthy connection", false, $e->getMessage());
}

// Test 3.2: Disconnected / Closed connection reconnect()
try {
    // Explicitly close the underlying mysqli connection
    if ($db && $db->conn_id instanceof \mysqli) {
        $db->conn_id->close();
    }
    
    // Calling reconnect() on closed connection must catch mysqli_sql_exception and set conn_id = FALSE
    $db->reconnect();
    assert_test(
        "reconnect() on closed connection catches exception and marks conn_id = FALSE",
        $db->conn_id === false
    );
} catch (\Throwable $e) {
    assert_test("reconnect() on closed connection catches exception", false, $e->getMessage());
}

// Test 3.3: Reconnect when conn_id is already FALSE
try {
    $db->conn_id = false;
    $db->reconnect();
    assert_test("reconnect() with conn_id === FALSE is a clean no-op", $db->conn_id === false);
} catch (\Throwable $e) {
    assert_test("reconnect() with conn_id === FALSE is a clean no-op", false, $e->getMessage());
}

// Test 3.4: Server-killed connection reconnect()
try {
    // Open connection A
    $connA = new \mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    $threadId = $connA->thread_id;
    
    // Open connection B to kill connection A
    $connB = new \mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    $connB->query("KILL $threadId");
    $connB->close();
    
    // Give MySQL a moment to terminate thread
    usleep(50000); // 50ms
    
    $driverKilled = new CI_DB_mysqli_driver($dbConfig);
    $driverKilled->conn_id = $connA;
    
    // Reconnect on killed connection must cleanly catch exception and set conn_id = FALSE
    $driverKilled->reconnect();
    assert_test(
        "reconnect() on server-killed connection catches exception and marks conn_id = FALSE",
        $driverKilled->conn_id === false
    );
} catch (\Throwable $e) {
    assert_test("reconnect() on server-killed connection", false, $e->getMessage());
}

// Test 3.5: Assert mysqli::ping() deprecation is trapped via subprocess
$pingOutput = shell_exec('php -r "error_reporting(E_ALL); ini_set(\'display_errors\', \'1\'); \$c = @new mysqli(\'' . $dbHost . '\', \'' . $dbUser . '\', \'' . $dbPass . '\', \'' . $dbName . '\', ' . $dbPort . '); \$c->ping();" 2>&1');
$pingDeprecConfirmed = (strpos($pingOutput, 'mysqli::ping() is deprecated') !== false);

assert_test(
    "PHP 8.5 natively deprecates mysqli::ping() [Deprecation trap confirmed]",
    $pingDeprecConfirmed,
    "Output: $pingOutput"
);

echo "\n";

// ========================================================================
// 4. STRESS TEST: #[\AllowDynamicProperties] on Base Classes
// ========================================================================
echo "[TEST SUITE 4: #[\AllowDynamicProperties] on CI3/MX/Base Classes]\n";

// Load core prerequisites first
require_once BASEPATH . 'core/Config.php';
require_once BASEPATH . 'core/Lang.php';
require_once BASEPATH . 'core/Controller.php';
require_once BASEPATH . 'core/Model.php';
require_once BASEPATH . 'core/Loader.php';

// Undecorated control class in subprocess to confirm PHP 8.5 dynamic property deprecation
$dynPropOutput = shell_exec('php -r "error_reporting(E_ALL); ini_set(\'display_errors\', \'1\'); class Unk {}; \$u = new Unk(); \$u->p = 1;" 2>&1');
$dynPropTrapConfirmed = (strpos($dynPropOutput, 'Creation of dynamic property') !== false && strpos($dynPropOutput, 'deprecated') !== false);

assert_test(
    "PHP 8.5 natively deprecates dynamic properties on undecorated classes [Trap confirmed]",
    $dynPropTrapConfirmed,
    "Output: $dynPropOutput"
);

// Classes to test for #[\AllowDynamicProperties]
$coreClasses = [
    'CI_Controller'       => BASEPATH . 'core/Controller.php',
    'CI_Model'            => BASEPATH . 'core/Model.php',
    'CI_Loader'           => BASEPATH . 'core/Loader.php',
    'CI_DB_driver'        => BASEPATH . 'database/DB_driver.php',
    'CI_DB_mysqli_driver' => BASEPATH . 'database/drivers/mysqli/mysqli_driver.php',
];

foreach ($coreClasses as $class => $file) {
    $ref = new \ReflectionClass($class);
    $attrs = $ref->getAttributes(\AllowDynamicProperties::class);
    assert_test(
        "Class $class has #[\AllowDynamicProperties] attribute",
        !empty($attrs),
        "Missing attribute on $class"
    );
}

// Check attribute in files for classes that require full CI runtime
$appFiles = [
    'application/third_party/MX/Base.php'       => 'class CI extends CI_Controller',
    'application/third_party/MX/Controller.php' => 'class MX_Controller',
    'application/third_party/MX/Loader.php'     => 'class MX_Loader',
    'application/core/Base_Controller.php'      => 'class Base_Controller',
    'application/core/Front_Controller.php'     => 'class Front_Controller',
    'application/core/Admin_Controller.php'     => 'class Admin_Controller',
    'application/core/BF_Model.php'             => 'class BF_Model',
    'application/libraries/Template.php'        => 'class Template',
    'application/modules/users/libraries/Auth.php' => 'class Auth',
];

foreach ($appFiles as $relPath => $classSig) {
    $fullPath = $baseDir . '/' . $relPath;
    $content = file_exists($fullPath) ? file_get_contents($fullPath) : '';
    // Look for #[\AllowDynamicProperties] preceding class declaration
    $hasAttr = preg_match('/#\[\\\\AllowDynamicProperties\]\s*(?:abstract\s+)?' . preg_quote($classSig, '/') . '/', $content);
    assert_test(
        "File $relPath has #[\AllowDynamicProperties] preceding $classSig",
        (bool)$hasAttr,
        "Pattern not matched in $relPath"
    );
}

// Test empirical assignment of dynamic properties without throwing deprecation on core instances
$instancesToTest = [
    'CI_Controller'       => (new \ReflectionClass('CI_Controller'))->newInstanceWithoutConstructor(),
    'CI_Model'            => (new \ReflectionClass('CI_Model'))->newInstanceWithoutConstructor(),
    'CI_Loader'           => (new \ReflectionClass('CI_Loader'))->newInstanceWithoutConstructor(),
    'CI_DB_mysqli_driver' => (new \ReflectionClass('CI_DB_mysqli_driver'))->newInstanceWithoutConstructor(),
];

foreach ($instancesToTest as $name => $obj) {
    try {
        $obj->adversarial_prop_1 = 'val_1';
        $obj->adversarial_prop_2 = [1, 2, 3];
        assert_test(
            "Dynamic property assignment on $name executes cleanly with zero deprecation",
            $obj->adversarial_prop_1 === 'val_1'
        );
    } catch (\Throwable $e) {
        assert_test("Dynamic property assignment on $name executes cleanly", false, $e->getMessage());
    }
}

echo "\n";

// ========================================================================
// 5. STRESS TEST: HTTP Smoke & Zero Deprecations on Live Pages
// ========================================================================
echo "[TEST SUITE 5: HTTP Smoke & Output Cleanliness]\n";

function http_get($url, $cookies = '') {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    if (!empty($cookies)) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    }
    $response = curl_exec($ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (PHP_VERSION_ID < 80500) {
        curl_close($ch);
    }
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    return ['code' => $httpCode, 'headers' => $headers, 'body' => $body];
}

function http_post($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (PHP_VERSION_ID < 80500) {
        curl_close($ch);
    }
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    return ['code' => $httpCode, 'headers' => $headers, 'body' => $body];
}

// 5.1 Test unauthenticated root returns redirect
$rootResp = http_get('http://127.0.0.1/');
assert_test(
    "GET / returns redirect (HTTP 302/303/307) or login page for unauthenticated request",
    in_array($rootResp['code'], [200, 301, 302, 303, 307, 308]),
    "Got HTTP " . $rootResp['code']
);

// 5.2 Test POST /login with valid credentials
$loginResp = http_post('http://127.0.0.1/login', [
    'username' => 'Rere',
    'password' => '12345',
    'login'    => '1'
]);
assert_test(
    "POST /login with valid credentials returns HTTP 303 See Other",
    $loginResp['code'] === 303,
    "Got HTTP " . $loginResp['code']
);

// Extract session cookie
preg_match_all('/Set-Cookie:\s*([^;]+)/mi', $loginResp['headers'], $cookieMatches);
$cookieHeader = !empty($cookieMatches[1]) ? implode('; ', $cookieMatches[1]) : '';
assert_test("POST /login returns session cookie (ci_demo_erp)", !empty($cookieHeader));

// 5.3 Access Dashboard with session cookie
$dashResp = http_get('http://127.0.0.1/', $cookieHeader);
assert_test(
    "GET / with session cookie loads Dashboard (HTTP 200)",
    $dashResp['code'] === 200,
    "Got HTTP " . $dashResp['code']
);

// 5.4 Assert zero PHP errors/warnings/deprecations leaked into HTML response
$hasPhpErrorInHtml = (
    stripos($dashResp['body'], '<b>Deprecated</b>') !== false ||
    stripos($dashResp['body'], '<b>Warning</b>') !== false ||
    stripos($dashResp['body'], '<b>Notice</b>') !== false ||
    stripos($dashResp['body'], '<b>Fatal error</b>') !== false ||
    stripos($dashResp['body'], 'A PHP Error was encountered') !== false
);
assert_test(
    "Dashboard HTML output is 100% clean of PHP warnings, notices, and deprecations",
    !$hasPhpErrorInHtml
);

// ========================================================================
// SUMMARY
// ========================================================================
echo "\n=======================================================\n";
echo "STRESS TEST SUMMARY:\n";
echo "  Total Passed: $passCount\n";
echo "  Total Failed: $failCount\n";
echo "=======================================================\n";

if ($failCount > 0) {
    echo "VERDICT: CHALLENGE_FAILED\n";
    exit(1);
} else {
    echo "VERDICT: APPROVE\n";
    exit(0);
}
