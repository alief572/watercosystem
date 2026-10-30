<?php
/**
 * Adversarial Empirical Stress Testing Suite for PHP 8.5 E2E Regression
 * Milestone 3 (Fase 5) Challenge Harness
 *
 * Usage inside container:
 *   docker exec waterco_web85 php tests/adversarial_e2e_challenge.php
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Autoload composer if available
$autoloadPaths = [
    __DIR__ . '/../vendor/autoload.php',
    '/var/www/html/vendor/autoload.php',
];
foreach ($autoloadPaths as $p) {
    if (file_exists($p)) {
        require_once $p;
        break;
    }
}

class AdversarialRunner
{
    private string $baseUrl;
    private int $totalTests = 0;
    private int $passedTests = 0;
    private int $failedTests = 0;
    private array $failures = [];
    private ?string $authenticatedCookie = null;

    public function __construct(string $baseUrl = 'http://127.0.0.1')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    private function log(string $msg, string $color = 'none'): void
    {
        $colors = [
            'green' => "\033[32m",
            'red' => "\033[31m",
            'yellow' => "\033[33m",
            'cyan' => "\033[36m",
            'bold' => "\033[1m",
            'dim' => "\033[2m",
            'none' => '',
        ];
        $reset = !empty($colors[$color]) ? "\033[0m" : '';
        echo ($colors[$color] ?? '') . $msg . $reset;
    }

    public function request(string $method, string $path, array $data = [], ?string $cookie = null, bool $followRedirects = false): array
    {
        $url = (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) ? $path : $this->baseUrl . '/' . ltrim($path, '/');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followRedirects);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        if ($cookie !== null) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $start = microtime(true);
        $raw = curl_exec($ch);
        $dur = (microtime(true) - $start) * 1000;

        if ($raw === false) {
            $err = curl_error($ch);
            return [
                'success' => false,
                'status' => 0,
                'headers' => [],
                'raw_headers' => '',
                'body' => '',
                'duration' => $dur,
                'error' => $err,
                'set_cookies' => [],
            ];
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $rawHeaderStr = substr($raw, 0, $headerSize);
        $body = substr($raw, $headerSize);

        $headers = [];
        $setCookies = [];
        $headerLines = explode("\r\n", trim($rawHeaderStr));
        foreach ($headerLines as $line) {
            if (strpos($line, ': ') !== false) {
                [$k, $v] = explode(': ', $line, 2);
                $headers[strtolower($k)][] = $v;
                if (strtolower($k) === 'set-cookie') {
                    $setCookies[] = $v;
                }
            }
        }

        return [
            'success' => true,
            'status' => $statusCode,
            'headers' => $headers,
            'raw_headers' => $rawHeaderStr,
            'body' => $body,
            'duration' => $dur,
            'error' => null,
            'set_cookies' => $setCookies,
        ];
    }

    public function runTest(string $category, string $testName, callable $fn): void
    {
        $this->totalTests++;
        $tag = sprintf("[%s] %s", $category, $testName);
        $this->log(sprintf("  %-65s ", $tag), "cyan");

        $start = microtime(true);
        try {
            $fn($this);
            $dur = (microtime(true) - $start) * 1000;
            $this->passedTests++;
            $this->log("PASS", "green");
            $this->log(sprintf(" (%dms)\n", round($dur)), "dim");
        } catch (\Throwable $e) {
            $dur = (microtime(true) - $start) * 1000;
            $this->failedTests++;
            $this->log("FAIL", "red");
            $this->log(sprintf(" (%dms)\n", round($dur)), "dim");
            $this->log("    >>> ERROR: " . $e->getMessage() . "\n", "red");
            $this->failures[] = [
                'tag' => $tag,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }
    }

    public function assert(bool $cond, string $msg): void
    {
        if (!$cond) {
            throw new \RuntimeException("Assertion failed: $msg");
        }
    }

    public function getAuthCookie(): string
    {
        if ($this->authenticatedCookie !== null) {
            return $this->authenticatedCookie;
        }

        $res = $this->request('POST', '/login', [
            'login' => '1',
            'username' => 'iman',
            'password' => 'iman',
        ]);

        $this->assert(in_array($res['status'], [302, 303]), "Expected 302/303 redirect on successful login, got {$res['status']}");

        $cookieVal = null;
        foreach ($res['set_cookies'] as $sc) {
            if (preg_match('/^ci_demo_erp=([^;]+)/', $sc, $m)) {
                $cookieVal = 'ci_demo_erp=' . $m[1];
                break;
            }
        }

        $this->assert($cookieVal !== null, "ci_demo_erp session cookie not found in login response");
        $this->authenticatedCookie = $cookieVal;
        return $this->authenticatedCookie;
    }

    public function summary(): int
    {
        echo "\n" . str_repeat('=', 80) . "\n";
        $this->log("ADVERSARIAL STRESS TEST CHALLENGE RESULTS\n", "bold");
        echo str_repeat('=', 80) . "\n";
        echo "Total Tests Run : {$this->totalTests}\n";
        $this->log("Passed          : {$this->passedTests}\n", "green");
        if ($this->failedTests > 0) {
            $this->log("Failed          : {$this->failedTests}\n", "red");
            echo "\nFailed Test Details:\n";
            foreach ($this->failures as $f) {
                $this->log(" - {$f['tag']}: {$f['error']} ({$f['file']}:{$f['line']})\n", "red");
            }
            return 1;
        } else {
            $this->log("Failed          : 0\n", "green");
            $this->log("OVERALL CHALLENGE STATUS: ALL ADVERSARIAL TESTS PASSED [APPROVE]\n", "green");
            return 0;
        }
    }
}

$runner = new AdversarialRunner('http://127.0.0.1');

echo "\n" . str_repeat('=', 80) . "\n";
echo "STARTING EMPIRICAL ADVERSARIAL CHALLENGE SUITE (PHP 8.5)\n";
echo "Target Base URL: http://127.0.0.1\n";
echo "Runtime: " . PHP_VERSION . "\n";
echo str_repeat('=', 80) . "\n";

// =============================================================================
// SECTION 1: AUTHENTICATION ADVERSARIAL STRESS TESTS
// =============================================================================
echo "\n--- SECTION 1: AUTH ADVERSARIAL STRESS TESTS ---\n";

// 1.1 Brute-force burst boundary rejection
$runner->runTest("AUTH", "Brute-force burst: 15 rapid invalid logins are rejected safely", function ($r) {
    for ($i = 1; $i <= 15; $i++) {
        $u = "adversary_bot_" . bin2hex(random_bytes(4));
        $p = "invalid_pass_" . bin2hex(random_bytes(4));
        $res = $r->request('POST', '/login', [
            'login' => '1',
            'username' => $u,
            'password' => $p,
        ]);

        $r->assert($res['status'] === 200 || in_array($res['status'], [302, 303]), "Request $i returned HTTP {$res['status']} instead of 200/302");
        $r->assert(!str_contains(strtolower($res['body']), 'fatal error'), "Request $i leaked PHP Fatal Error");
        $r->assert(!str_contains(strtolower($res['body']), 'database error'), "Request $i leaked Database Error");

        // Verify protected dashboard is NOT accessible with whatever cookie might have been issued
        $cookie = null;
        foreach ($res['set_cookies'] as $sc) {
            if (preg_match('/^ci_demo_erp=([^;]+)/', $sc, $m) && $m[1] !== 'deleted') {
                $cookie = 'ci_demo_erp=' . $m[1];
            }
        }
        $dash = $r->request('GET', '/', [], $cookie);
        $r->assert(in_array($dash['status'], [302, 303, 307]), "Unauthenticated user accessed dashboard with status {$dash['status']}");
    }
});

// 1.2 SQL Injection Evasion in Login Form
$sqliPayloads = [
    "admin' OR '1'='1",
    "admin' OR '1'='1' -- ",
    "admin' /*",
    "' OR 1=1 -- ",
    "' OR ''='",
    "admin' UNION SELECT 1, 'admin', 'hash', 1, 1 -- ",
    "'; DROP TABLE users; --",
    "' OR '1'='1' #",
    "\" OR \"\"=\"",
    "admin' AND SLEEP(0.1) -- ",
];

foreach ($sqliPayloads as $idx => $payload) {
    $runner->runTest("AUTH-SQLI", "SQLi evasion test #$idx: " . substr($payload, 0, 25), function ($r) use ($payload) {
        $res = $r->request('POST', '/login', [
            'login' => '1',
            'username' => $payload,
            'password' => $payload,
        ]);

        // Must reject authentication: status 200 with login form, or redirect back to login
        $r->assert($res['status'] === 200 || in_array($res['status'], [302, 303]), "SQLi triggered HTTP {$res['status']}");
        $r->assert(!str_contains($res['body'], 'You have an error in your SQL syntax'), "SQL Syntax Error leaked");
        $r->assert(!str_contains($res['body'], 'Database Error'), "Database Error message leaked");
        $r->assert(!str_contains($res['body'], 'Fatal error'), "Fatal Error triggered by SQLi");
        $r->assert(!str_contains($res['body'], 'A Database Error Occurred'), "CI Database Error page rendered");

        // Ensure no active session was granted
        $cookie = null;
        foreach ($res['set_cookies'] as $sc) {
            if (preg_match('/^ci_demo_erp=([^;]+)/', $sc, $m) && $m[1] !== 'deleted') {
                $cookie = 'ci_demo_erp=' . $m[1];
            }
        }
        $dash = $r->request('GET', '/', [], $cookie);
        $r->assert(in_array($dash['status'], [302, 303, 307]), "SQLi granted unauthorized dashboard access! HTTP {$dash['status']}");
    });
}

// 1.3 Expired & Manipulated Session Cookie Handling
$tamperedCookies = [
    'forged_deadbeef_session_id_1234567890',
    'deleted',
    '',
    '../../../../etc/passwd',
    's:40:"0000000000000000000000000000000000000000";',
    str_repeat('A', 500),
    '%00%00%00%00',
    '<script>alert(1)</script>',
];

foreach ($tamperedCookies as $idx => $tampered) {
    $runner->runTest("AUTH-SESSION", "Tampered session cookie #$idx: " . substr($tampered, 0, 25), function ($r) use ($tampered) {
        $cookieHeader = "ci_demo_erp=" . urlencode($tampered);
        $res = $r->request('GET', '/', [], $cookieHeader);

        // Expect clean redirect to /login
        $r->assert(in_array($res['status'], [301, 302, 303, 307]), "Tampered session cookie did not redirect to login, got status {$res['status']}");
        $r->assert(!str_contains($res['body'], 'Fatal error'), "Tampered cookie triggered fatal error");
        $r->assert(!str_contains($res['body'], 'session_start():'), "Tampered cookie triggered session_start PHP warning");
        $r->assert(!str_contains($res['body'], 'Uncaught'), "Tampered cookie triggered uncaught exception");

        // Verify Location header points to login
        $location = $res['headers']['location'][0] ?? '';
        $r->assert(str_contains($location, 'login'), "Redirect Location does not contain 'login': $location");
    });
}

// =============================================================================
// SECTION 2: BINARY OUTPUT INTEGRITY & PURITY STRESS TESTS
// =============================================================================
echo "\n--- SECTION 2: BINARY OUTPUT INTEGRITY STRESS TESTS ---\n";

// 2.1 HTML2PDF (TCPDF engine) Exact Byte Purity
$runner->runTest("BINARY-PDF", "HTML2PDF: Exact %PDF- byte purity, zero leading warning text", function ($r) {
    $cookie = $r->getAuthCookie();
    $res = $r->request('GET', '/wt_delivery_order/printDO/D2200001', [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200 for HTML2PDF printDO, got {$res['status']}");
    $body = $res['body'];
    $r->assert(strlen($body) > 1000, "HTML2PDF output too small: " . strlen($body) . " bytes");

    // Exact magic byte check at offset 0
    $magic = substr($body, 0, 5);
    $r->assert($magic === '%PDF-', "HTML2PDF byte 0..4 MUST be '%PDF-', got " . var_export($magic, true));

    // Verify byte 0 is strictly 0x25 '%'
    $byte0 = ord($body[0]);
    $r->assert($byte0 === 0x25, "HTML2PDF byte 0 is not 0x25 '%', leading noise detected: 0x" . dechex($byte0));

    // Check Content-Type header
    $ct = $res['headers']['content-type'][0] ?? '';
    $r->assert(str_contains($ct, 'application/pdf'), "Expected Content-Type application/pdf, got $ct");

    // Check EOF trailer
    $tail = substr($body, -1024);
    $r->assert(str_contains($tail, '%%EOF'), "HTML2PDF missing %%EOF trailer");

    // Check no PHP error messages anywhere inside the PDF binary
    $r->assert(!str_contains($body, '<b>Deprecated</b>'), "HTML2PDF contains PHP Deprecated banner");
    $r->assert(!str_contains($body, '<b>Warning</b>'), "HTML2PDF contains PHP Warning banner");
    $r->assert(!str_contains($body, '<b>Fatal error</b>'), "HTML2PDF contains PHP Fatal error banner");
});

// 2.2 mPDF Exact Byte Purity
$runner->runTest("BINARY-PDF", "mPDF: Exact %PDF- byte purity, zero leading warning text", function ($r) {
    $cookie = $r->getAuthCookie();
    $res = $r->request('GET', '/wt_delivery_order/print_do/D2200001', [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200 for mPDF print_do, got {$res['status']}");
    $body = $res['body'];
    $r->assert(strlen($body) > 1000, "mPDF output too small: " . strlen($body) . " bytes");

    // Exact magic byte check at offset 0
    $magic = substr($body, 0, 5);
    $r->assert($magic === '%PDF-', "mPDF byte 0..4 MUST be '%PDF-', got " . var_export($magic, true));

    // Verify byte 0 is strictly 0x25 '%'
    $byte0 = ord($body[0]);
    $r->assert($byte0 === 0x25, "mPDF byte 0 is not 0x25 '%', leading noise detected: 0x" . dechex($byte0));

    // Check Content-Type header
    $ct = $res['headers']['content-type'][0] ?? '';
    $r->assert(str_contains($ct, 'application/pdf'), "Expected Content-Type application/pdf, got $ct");

    // Check EOF trailer
    $tail = substr($body, -1024);
    $r->assert(str_contains($tail, '%%EOF'), "mPDF missing %%EOF trailer");

    // Check no PHP warnings
    $r->assert(!str_contains($body, '<b>Deprecated</b>'), "mPDF contains PHP Deprecated banner");
    $r->assert(!str_contains($body, '<b>Warning</b>'), "mPDF contains PHP Warning banner");
    $r->assert(!str_contains($body, '<b>Notice</b>'), "mPDF contains PHP Notice banner");
});

// 2.3 mPDF Non-Existent Entity Handling
$runner->runTest("BINARY-PDF", "mPDF: Non-existent DO entity yields clean %PDF without crash", function ($r) {
    $cookie = $r->getAuthCookie();
    $res = $r->request('GET', '/wt_delivery_order/print_do/NONEXISTENT_DO_99999', [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200 for mPDF non-existent DO, got {$res['status']}");
    $body = $res['body'];
    $magic = substr($body, 0, 5);
    $r->assert($magic === '%PDF-', "mPDF byte 0..4 MUST be '%PDF-', got " . var_export($magic, true));
    $r->assert(!str_contains($body, 'Fatal error'), "mPDF non-existent entity threw Fatal Error");
});

// 2.4 PhpSpreadsheet Excel Export Binary Integrity & Parsing
$runner->runTest("BINARY-XLSX", "PhpSpreadsheet: Valid PK zip archive & parseable sheets", function ($r) {
    $cookie = $r->getAuthCookie();
    $res = $r->request('GET', '/report_progress_po/export_excel?start_date=2026-10-01&end_date=2026-10-31', [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200 for Excel export, got {$res['status']}");
    $body = $res['body'];
    $r->assert(strlen($body) > 1000, "Excel export output too small: " . strlen($body) . " bytes");

    // Check PK ZIP magic signature at byte 0..3: PK\x03\x04
    $magic = substr($body, 0, 4);
    $r->assert($magic === "PK\x03\x04", "Excel file MUST start with PK\\x03\\x04 signature, got " . bin2hex($magic));

    // Strict byte 0 check: 'P' (0x50)
    $byte0 = ord($body[0]);
    $r->assert($byte0 === 0x50, "Excel byte 0 is not 0x50 'P', leading noise detected: 0x" . dechex($byte0));

    // Save to temp file and parse with PhpSpreadsheet Reader
    $tmpFile = tempnam(sys_get_temp_dir(), 'adv_xlsx_') . '.xlsx';
    file_put_contents($tmpFile, $body);

    try {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($tmpFile);
        $sheetNames = $spreadsheet->getSheetNames();

        $r->assert(in_array('Ringkasan', $sheetNames), "Sheet 'Ringkasan' not found in XLSX: " . implode(', ', $sheetNames));
        $r->assert(in_array('Data PO', $sheetNames), "Sheet 'Data PO' not found in XLSX: " . implode(', ', $sheetNames));

        // Inspect cell contents
        $ringkasan = $spreadsheet->getSheetByName('Ringkasan');
        $titleCell = $ringkasan->getCell('A1')->getValue();
        $r->assert(!empty($titleCell), "Ringkasan A1 title cell is empty");

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
    } finally {
        @unlink($tmpFile);
    }
});

// =============================================================================
// SECTION 3: DATATABLES ADVERSARIAL STRESS TESTS
// =============================================================================
echo "\n--- SECTION 3: DATATABLES ADVERSARIAL STRESS TESTS ---\n";

// 3.1 Piutang Invoice: Extreme Pagination & Out-of-Bounds Handling
$runner->runTest("DATATABLES", "Piutang Invoice: start=999999 offset yields empty slice", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_piutang_invoice/data?tanggal=2026-10-01&draw=10&start=999999&length=10';
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
    $json = json_decode($res['body'], true);
    $r->assert(is_array($json), "Response is not valid JSON");
    $r->assert(isset($json['recordsTotal']) && $json['recordsTotal'] > 0, "Missing recordsTotal");
    $r->assert(isset($json['data']) && count($json['data']) === 0, "Expected 0 records for start=999999");
});

$runner->runTest("DATATABLES", "Piutang Invoice: length=-1 boundary rejected defensively (400)", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_piutang_invoice/data?tanggal=2026-10-01&draw=11&start=0&length=-1';
    $res = $r->request('GET', $url, [], $cookie);

    // Defensive parameter validation properly returns HTTP 400 Bad Request
    $r->assert($res['status'] === 400, "Expected defensive HTTP 400 for length=-1, got {$res['status']}");
    $r->assert(!str_contains($res['body'], 'Fatal error'), "Fatal error on invalid length");
});

$runner->runTest("DATATABLES", "Piutang Invoice: Negative start=-10 rejected defensively (400)", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_piutang_invoice/data?tanggal=2026-10-01&draw=12&start=-10&length=10';
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 400, "Expected defensive HTTP 400 for start=-10, got {$res['status']}");
});

// 3.2 Progress PO: Extreme Pagination & Out-of-Bounds Handling
$runner->runTest("DATATABLES", "Progress PO: start=999999 offset yields empty slice", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_progress_po/data_po?start_date=2026-10-01&end_date=2026-10-31&draw=20&start=999999&length=10';
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
    $json = json_decode($res['body'], true);
    $r->assert(is_array($json), "Response is not valid JSON");
    $r->assert(isset($json['data']) && count($json['data']) === 0, "Expected 0 records for start=999999");
});

$runner->runTest("DATATABLES", "Progress PO: length=-1 boundary rejected defensively (422)", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_progress_po/data_po?start_date=2026-10-01&end_date=2026-10-31&draw=21&start=0&length=-1';
    $res = $r->request('GET', $url, [], $cookie);

    // Progress PO rules reject non-digit parameter with HTTP 422
    $r->assert($res['status'] === 422, "Expected defensive HTTP 422 for length=-1, got {$res['status']}");
    $json = json_decode($res['body'], true);
    $r->assert(isset($json['error']), "Expected JSON error envelope from Progress_po_rules");
});

$runner->runTest("DATATABLES", "Progress PO: Negative start=-10 rejected defensively (422)", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_progress_po/data_po?start_date=2026-10-01&end_date=2026-10-31&draw=22&start=-10&length=10';
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 422, "Expected defensive HTTP 422 for start=-10, got {$res['status']}");
});

// 3.3 DataTables Adversarial Search Payloads (SQLi, XSS, Multi-byte)
$advSearches = [
    "SQLi Quote" => "' OR '1'='1",
    "SQLi Union" => "' UNION SELECT 1,2,3,4,5 -- ",
    "SQLi Semicolon" => "'; DROP TABLE dummy; -- ",
    "XSS Payload" => "<script>alert('pwned')</script>",
    "Special Chars" => "%_'\"\\!@#$%^&*()[]{}:;<>,.?",
    "Long 100-char String" => str_repeat("ABC123_", 14),
];

foreach ($advSearches as $sName => $sVal) {
    // Test on Progress PO with scalar search
    $runner->runTest("DATATABLES-SEARCH", "Progress PO search: $sName", function ($r) use ($sVal) {
        $cookie = $r->getAuthCookie();
        $url = '/report_progress_po/data_po?' . http_build_query([
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
            'draw' => 30,
            'start' => 0,
            'length' => 10,
            'search' => $sVal,
        ]);
        $res = $r->request('GET', $url, [], $cookie);

        $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
        $r->assert(!str_contains($res['body'], 'Fatal error'), "Search '$sVal' triggered Fatal error");
        $r->assert(!str_contains($res['body'], 'You have an error in your SQL syntax'), "SQL syntax error leaked");
        $json = json_decode($res['body'], true);
        $r->assert(is_array($json), "Response is not valid JSON");
        $r->assert(isset($json['recordsTotal']), "Missing recordsTotal");
    });

    // Test on Piutang Invoice with adversarial no_invoice filter
    $runner->runTest("DATATABLES-SEARCH", "Piutang Invoice filter: $sName", function ($r) use ($sVal) {
        $cookie = $r->getAuthCookie();
        $url = '/report_piutang_invoice/data?' . http_build_query([
            'tanggal' => '2026-10-01',
            'draw' => 40,
            'start' => 0,
            'length' => 10,
            'no_invoice' => $sVal,
        ]);
        $res = $r->request('GET', $url, [], $cookie);

        $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
        $r->assert(!str_contains($res['body'], 'Fatal error'), "Filter '$sVal' triggered Fatal error");
        $r->assert(!str_contains($res['body'], 'You have an error in your SQL syntax'), "SQL syntax error leaked");
        $json = json_decode($res['body'], true);
        $r->assert(is_array($json), "Response is not valid JSON");
    });
}

// 3.4 Multi-byte and Encoding Resilience
$runner->runTest("DATATABLES-SEARCH", "Progress PO: Multi-byte UTF-8 emoji search handles cleanly", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_progress_po/data_po?' . http_build_query([
        'start_date' => '2026-10-01',
        'end_date' => '2026-10-31',
        'draw' => 50,
        'start' => 0,
        'length' => 10,
        'search' => '🔥🚀 Waterco ERP 日本語 測試',
    ]);
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
    $json = json_decode($res['body'], true);
    $r->assert(is_array($json), "Response is not valid JSON");
});

$runner->runTest("DATATABLES-SEARCH", "Piutang Invoice: Latin-1 compatible UTF-8 filter handles cleanly", function ($r) {
    $cookie = $r->getAuthCookie();
    $url = '/report_piutang_invoice/data?' . http_build_query([
        'tanggal' => '2026-10-01',
        'draw' => 51,
        'start' => 0,
        'length' => 10,
        'no_invoice' => 'Waterco Café Invoice 123',
    ]);
    $res = $r->request('GET', $url, [], $cookie);

    $r->assert($res['status'] === 200, "Expected HTTP 200, got {$res['status']}");
    $json = json_decode($res['body'], true);
    $r->assert(is_array($json), "Response is not valid JSON");
});

exit($runner->summary());
