<?php
/**
 * Opaque-Box E2E Regression Test Suite for PHP 8.5 Upgrade
 *
 * Validates CodeIgniter 3.1.13 HMVC, mPDF, HTML2PDF, PhpSpreadsheet, DataTables,
 * and session state under PHP 8.5 runtime.
 *
 * Usage:
 *   docker exec waterco_web85 php tests/e2e_php85_regression_test.php [options]
 *   php tests/e2e_php85_regression_test.php --base-url=http://localhost:8085
 *
 * Options:
 *   --base-url=<url>   Base URL of the application (default: auto-detect 127.0.0.1 / localhost:8085)
 *   --tier=<1|2|3|4|all> Run specific tier (default: all)
 *   --verbose          Display verbose HTTP request and response information
 *   --help             Show help documentation
 */

// Load Composer autoloader if available (for PhpSpreadsheet inspection)
$autoloadPaths = [
    __DIR__ . '/../vendor/autoload.php',
    dirname(__DIR__) . '/vendor/autoload.php',
    '/var/www/html/vendor/autoload.php',
];
foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

// -----------------------------------------------------------------------------
// Terminal Colors & Output Helpers
// -----------------------------------------------------------------------------
class TermColor
{
    private static bool $supportsColor = true;

    public static function init(): void
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            self::$supportsColor = (getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON' || getenv('TERM') !== false);
            if (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT)) {
                self::$supportsColor = true;
            }
        }
    }

    public static function color(string $text, string $color): string
    {
        if (!self::$supportsColor) {
            return $text;
        }

        $codes = [
            'reset'   => "\033[0m",
            'bold'    => "\033[1m",
            'dim'     => "\033[2m",
            'red'     => "\033[31m",
            'green'   => "\033[32m",
            'yellow'  => "\033[33m",
            'blue'    => "\033[34m",
            'magenta' => "\033[35m",
            'cyan'    => "\033[36m",
            'white'   => "\033[37m",
            'bg_red'  => "\033[41m",
            'bg_green'=> "\033[42m",
        ];

        return ($codes[$color] ?? '') . $text . $codes['reset'];
    }
}
TermColor::init();

// -----------------------------------------------------------------------------
// Simple HTTP Client with Session / Cookie Support
// -----------------------------------------------------------------------------
class E2EHttpClient
{
    private string $baseUrl;
    private string $cookieFile;
    private array $inMemoryCookies = [];
    private bool $verbose;

    public function __construct(string $baseUrl, bool $verbose = false)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->verbose = $verbose;
        $this->resetCookieJar();
    }

    public function resetCookieJar(): void
    {
        $this->inMemoryCookies = [];
        $tempDir = sys_get_temp_dir();
        $this->cookieFile = $tempDir . '/e2e_ci_cookie_' . bin2hex(random_bytes(6)) . '.txt';
        if (file_exists($this->cookieFile)) {
            @unlink($this->cookieFile);
        }
        @touch($this->cookieFile);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getCookieFile(): string
    {
        return $this->cookieFile;
    }

    public function getCookies(): array
    {
        $cookies = $this->inMemoryCookies;
        if (file_exists($this->cookieFile)) {
            $lines = file($this->cookieFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with($line, '#HttpOnly_')) {
                    $line = substr($line, 10);
                } elseif (empty($line) || $line[0] === '#') {
                    continue;
                }
                $parts = preg_split('/\t+/', $line);
                if (count($parts) >= 7) {
                    $cookies[$parts[5]] = $parts[6];
                }
            }
        }
        return $cookies;
    }

    public function getCookie(string $name): ?string
    {
        $cookies = $this->getCookies();
        return $cookies[$name] ?? null;
    }

    public function request(string $method, string $path, array $data = [], array $headers = [], bool $followRedirects = false): array
    {
        $url = (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) ? $path : $this->baseUrl . '/' . ltrim($path, '/');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followRedirects);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        // If in-memory cookies exist, format them into Cookie header
        if (!empty($this->inMemoryCookies)) {
            $cookiePairs = [];
            foreach ($this->inMemoryCookies as $k => $v) {
                $cookiePairs[] = "$k=$v";
            }
            curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cookiePairs));
        }

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $startTime = microtime(true);
        $rawResponse = curl_exec($ch);
        $durationMs = (microtime(true) - $startTime) * 1000;

        if ($rawResponse === false) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            unset($ch);
            return [
                'success'    => false,
                'statusCode' => 0,
                'headers'    => [],
                'body'       => '',
                'durationMs' => $durationMs,
                'error'      => "cURL Error ($errno): $error",
            ];
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        unset($ch);

        $rawHeaderStr = substr($rawResponse, 0, $headerSize);
        $body = substr($rawResponse, $headerSize);

        // Parse headers
        $headerLines = explode("\r\n", trim($rawHeaderStr));
        $parsedHeaders = [];
        foreach ($headerLines as $line) {
            if (strpos($line, ': ') !== false) {
                [$k, $v] = explode(': ', $line, 2);
                $parsedHeaders[strtolower($k)][] = $v;
            }
        }

        // Capture Set-Cookie headers into in-memory store
        if (isset($parsedHeaders['set-cookie'])) {
            foreach ($parsedHeaders['set-cookie'] as $cookieLine) {
                if (preg_match('/^([^=;\s]+)=([^;]+)/', $cookieLine, $matches)) {
                    $name = trim($matches[1]);
                    $val = trim($matches[2]);
                    if ($val === 'deleted' || $val === '') {
                        unset($this->inMemoryCookies[$name]);
                    } else {
                        $this->inMemoryCookies[$name] = $val;
                    }
                }
            }
        }

        if ($this->verbose) {
            echo TermColor::color("\n--- HTTP {$method} {$url} [{$statusCode}] (" . round($durationMs, 1) . "ms) ---\n", "cyan");
            echo TermColor::color("Headers:\n" . trim($rawHeaderStr) . "\n", "dim");
            if (strlen($body) < 1000 && !preg_match('/[\x00-\x08\x0E-\x1F]/', $body)) {
                echo TermColor::color("Body:\n" . $body . "\n", "dim");
            } else {
                echo TermColor::color("Body: [binary/long data " . strlen($body) . " bytes]\n", "dim");
            }
        }

        return [
            'success'    => true,
            'statusCode' => $statusCode,
            'headers'    => $parsedHeaders,
            'rawHeaders' => $rawHeaderStr,
            'body'       => $body,
            'durationMs' => $durationMs,
            'error'      => null,
        ];
    }

    public function get(string $path, array $headers = [], bool $followRedirects = false): array
    {
        return $this->request('GET', $path, [], $headers, $followRedirects);
    }

    public function post(string $path, array $data = [], array $headers = [], bool $followRedirects = false): array
    {
        return $this->request('POST', $path, $data, $headers, $followRedirects);
    }

    public function __destruct()
    {
        if (file_exists($this->cookieFile)) {
            @unlink($this->cookieFile);
        }
    }
}

// -----------------------------------------------------------------------------
// Test Case Runner & Assertion Framework
// -----------------------------------------------------------------------------
class E2ETestRunner
{
    private E2EHttpClient $client;
    private int $totalCount = 0;
    private int $passedCount = 0;
    private int $failedCount = 0;
    private int $skippedCount = 0;
    private array $failures = [];
    private float $suiteStartTime;
    private string $activeTier = 'all';

    public function __construct(E2EHttpClient $client, string $activeTier = 'all')
    {
        $this->client = $client;
        $this->activeTier = $activeTier;
        $this->suiteStartTime = microtime(true);
    }

    public function getClient(): E2EHttpClient
    {
        return $this->client;
    }

    public function shouldRunTier(int $tier): bool
    {
        if ($this->activeTier === 'all' || (string)$this->activeTier === (string)$tier) {
            return true;
        }
        return false;
    }

    public function printTierHeader(int $tier, string $title, string $description): void
    {
        echo "\n" . TermColor::color("================================================================================", "blue") . "\n";
        echo TermColor::color(" TIER {$tier}: {$title}", "bold") . "\n";
        echo TermColor::color(" {$description}", "dim") . "\n";
        echo TermColor::color("================================================================================", "blue") . "\n";
    }

    public function runTest(string $id, string $title, callable $testCallback): void
    {
        $this->totalCount++;
        echo sprintf("  %-12s %-50s ", TermColor::color("[$id]", "cyan"), $title);

        $start = microtime(true);
        try {
            $testCallback($this->client, $this);
            $duration = (microtime(true) - $start) * 1000;
            $this->passedCount++;
            echo TermColor::color("PASS", "green") . sprintf(" (%dms)\n", round($duration));
        } catch (\AssertionError | \Exception $e) {
            $duration = (microtime(true) - $start) * 1000;
            $this->failedCount++;
            echo TermColor::color("FAIL", "red") . sprintf(" (%dms)\n", round($duration));
            $this->failures[] = [
                'id'       => $id,
                'title'    => $title,
                'message'  => $e->getMessage(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
            ];
            echo "    " . TermColor::color("Error: " . $e->getMessage(), "red") . "\n";
        }
    }

    // --- Assertion Helpers ---

    public function assert(bool $condition, string $message): void
    {
        if (!$condition) {
            throw new \AssertionError($message);
        }
    }

    public function assertEquals($expected, $actual, string $message = ''): void
    {
        if ($expected !== $actual) {
            $msg = $message ? "$message (Expected " . var_export($expected, true) . ", got " . var_export($actual, true) . ")"
                            : "Expected " . var_export($expected, true) . ", got " . var_export($actual, true);
            throw new \AssertionError($msg);
        }
    }

    public function assertGreaterThan($expected, $actual, string $message = ''): void
    {
        if (!($actual > $expected)) {
            $msg = $message ? "$message (Expected > $expected, got $actual)"
                            : "Expected > $expected, got $actual";
            throw new \AssertionError($msg);
        }
    }

    public function assertContains(string $needle, string $haystack, string $message = ''): void
    {
        if (strpos($haystack, $needle) === false) {
            $preview = strlen($haystack) > 120 ? substr($haystack, 0, 120) . '...' : $haystack;
            $msg = $message ? "$message (String does not contain '$needle'. Preview: $preview)"
                            : "String does not contain '$needle'. Preview: $preview";
            throw new \AssertionError($msg);
        }
    }

    public function assertNotContains(string $needle, string $haystack, string $message = ''): void
    {
        if (strpos($haystack, $needle) !== false) {
            $msg = $message ? "$message (String unexpectedly contains '$needle')"
                            : "String unexpectedly contains '$needle'";
            throw new \AssertionError($msg);
        }
    }

    public function assertRedirect(array $response, string $expectedLocationContains = '', string $message = ''): void
    {
        $code = $response['statusCode'];
        $isRedirect = in_array($code, [301, 302, 303, 307, 308], true);
        if (!$isRedirect) {
            $preview = strlen($response['body']) > 200 ? substr(strip_tags($response['body']), 0, 200) . '...' : strip_tags($response['body']);
            $msg = $message ? "$message (Expected redirect 301/302/303/307, got $code. Preview: $preview)"
                            : "Expected redirect 301/302/303/307, got $code. Preview: $preview";
            throw new \AssertionError($msg);
        }
        if ($expectedLocationContains !== '') {
            $location = $response['headers']['location'][0] ?? '';
            $this->assertContains($expectedLocationContains, $location, "Redirect Location header does not contain '$expectedLocationContains' (got '$location')");
        }
    }

    public function assertNoPhpErrors(string $body): void
    {
        $patterns = [
            'A PHP Error was encountered',
            'Severity: Notice',
            'Severity: Warning',
            'Severity: Deprecated',
            'Fatal error:',
            'Uncaught Error:',
            'Uncaught Exception:',
            'Deprecated: Creation of dynamic property',
        ];

        foreach ($patterns as $pattern) {
            if (strpos($body, $pattern) !== false) {
                $pos = strpos($body, $pattern);
                $snippet = substr($body, max(0, $pos - 50), 200);
                throw new \AssertionError("PHP Error/Deprecation found in response: '$pattern'. Snippet: $snippet");
            }
        }
    }

    public function assertValidJson(string $body): array
    {
        $data = json_decode($body, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            $preview = substr(strip_tags($body), 0, 200);
            throw new \AssertionError("Invalid JSON response (" . json_last_error_msg() . "). Preview: $preview");
        }
        return $data;
    }

    public function assertPdfValid(string $content, int $minSize = 2000): void
    {
        $this->assertGreaterThan($minSize, strlen($content), "PDF size is unexpectedly small (" . strlen($content) . " bytes)");
        $this->assert(str_starts_with($content, '%PDF-'), "PDF magic header missing (expected '%PDF-', got '" . substr($content, 0, 7) . "')");
        $this->assertContains('%%EOF', substr($content, -1024), "PDF EOF marker missing in trailer");
        $this->assertNoPhpErrors($content);
    }

    public function assertXlsxValid(string $content, int $minSheets = 2, array $expectedSheetNames = ['Ringkasan', 'Data PO']): void
    {
        $this->assertGreaterThan(2000, strlen($content), "Excel size is unexpectedly small (" . strlen($content) . " bytes)");
        $this->assert(str_starts_with($content, "PK\x03\x04"), "Excel PK ZIP magic bytes missing (expected PK\\x03\\x04)");
        $this->assertNoPhpErrors($content);

        // If PhpSpreadsheet is installed, validate the workbook structure authoritatively
        if (class_exists(\PhpOffice\PhpSpreadsheet\Reader\Xlsx::class)) {
            $tmpFile = tempnam(sys_get_temp_dir(), 'e2e_xlsx_') . '.xlsx';
            file_put_contents($tmpFile, $content);

            try {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($tmpFile);

                $sheetCount = $spreadsheet->getSheetCount();
                $this->assert($sheetCount >= $minSheets, "XLSX sheet count mismatch: expected at least $minSheets, found $sheetCount");

                $sheetNames = $spreadsheet->getSheetNames();
                foreach ($expectedSheetNames as $expectedName) {
                    $this->assert(in_array($expectedName, $sheetNames, true), "Expected sheet '$expectedName' not found in XLSX. Found: " . implode(', ', $sheetNames));
                }

                $sheet1 = $spreadsheet->getSheet(0);
                $this->assert(!empty($sheet1->getCell('A1')->getValue()), "Sheet 1 Cell A1 is unexpectedly empty");

                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            } finally {
                @unlink($tmpFile);
            }
        }
    }

    public function printSummary(): int
    {
        $totalDuration = (microtime(true) - $this->suiteStartTime);

        echo "\n" . TermColor::color("================================================================================", "blue") . "\n";
        echo TermColor::color(" E2E REGRESSION TEST SUITE SUMMARY (PHP 8.5)", "bold") . "\n";
        echo TermColor::color("================================================================================", "blue") . "\n";
        echo sprintf(" Total Tests Run:   %d\n", $this->totalCount);
        echo sprintf(" Passed:            %s\n", TermColor::color((string)$this->passedCount, "green"));
        echo sprintf(" Failed:            %s\n", $this->failedCount > 0 ? TermColor::color((string)$this->failedCount, "red") : "0");
        echo sprintf(" Execution Time:    %.2f seconds\n", $totalDuration);

        if (!empty($this->failures)) {
            echo "\n" . TermColor::color("FAILURES (" . count($this->failures) . "):", "red") . "\n";
            foreach ($this->failures as $i => $f) {
                echo sprintf("  %d) [%s] %s\n     %s\n     at %s:%d\n", $i + 1, $f['id'], $f['title'], $f['message'], $f['file'], $f['line']);
            }
        }

        echo "--------------------------------------------------------------------------------\n";
        if ($this->failedCount === 0 && $this->totalCount > 0) {
            echo TermColor::color(" OVERALL STATUS: ALL TESTS PASSED [PASS]", "bg_green") . "\n\n";
            return 0;
        } else {
            echo TermColor::color(" OVERALL STATUS: TEST SUITE FAILED [FAIL]", "bg_red") . "\n\n";
            return 1;
        }
    }
}

// -----------------------------------------------------------------------------
// CLI Argument Parsing & Auto-Detection
// -----------------------------------------------------------------------------
$options = getopt('', ['base-url:', 'tier:', 'verbose', 'help']);

if (isset($options['help'])) {
    echo <<<HELP
Watercosystem PHP 8.5 E2E Regression Test Suite

Usage:
  php tests/e2e_php85_regression_test.php [options]

Options:
  --base-url=<url>   Base URL (e.g., http://127.0.0.1 or http://localhost:8085)
  --tier=<1|2|3|4|all> Run specific test tier (default: all)
  --verbose          Display verbose HTTP headers and requests
  --help             Display this help message

HELP;
    exit(0);
}

$baseUrl = $options['base-url'] ?? null;
$activeTier = $options['tier'] ?? 'all';
$verbose = isset($options['verbose']);

// Auto-detect base URL if not explicitly provided
if (!$baseUrl) {
    $ch = curl_init('http://127.0.0.1/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    unset($ch);

    if ($code === 200 || $code === 302 || $code === 303 || $code === 307) {
        $baseUrl = 'http://127.0.0.1';
    } else {
        $baseUrl = 'http://localhost:8085';
    }
}

echo TermColor::color("Starting PHP 8.5 E2E Regression Test Suite...\n", "bold");
echo "Target Base URL: " . TermColor::color($baseUrl, "yellow") . "\n";
echo "Active Tier:     " . TermColor::color($activeTier, "cyan") . "\n";
echo "PHP Runtime:     " . PHP_VERSION . " (" . PHP_SAPI . ")\n";

$client = new E2EHttpClient($baseUrl, $verbose);
$runner = new E2ETestRunner($client, $activeTier);

// Helper to determine active Progress PO endpoint (support data and data_po)
function getProgressPoDataEndpoint(E2EHttpClient $http): string
{
    $test = $http->get('/report_progress_po/data_po?start_date=2026-10-01&end_date=2026-10-31');
    if ($test['statusCode'] === 200) {
        return '/report_progress_po/data_po';
    }
    return '/report_progress_po/data';
}

// =============================================================================
// TIER 1: Feature Coverage (Core Functional Contracts)
// =============================================================================
if ($runner->shouldRunTier(1)) {
    $runner->printTierHeader(1, "Feature Coverage", "Validates core functional contracts: Auth, Dashboard, DataTables, HTML2PDF, mPDF, and PhpSpreadsheet");

    // TC-T1-01: Admin Login Authentication
    $runner->runTest("TC-T1-01", "Admin Login (iman:iman) yields HTTP 303 & session cookie", function (E2EHttpClient $http, E2ETestRunner $t) {
        $http->resetCookieJar();
        $res = $http->post('/login', [
            'login'    => '1',
            'username' => 'iman',
            'password' => 'iman',
        ]);

        $t->assertRedirect($res, '/', "Expected redirect to dashboard on successful login");
        $cookie = $http->getCookie('ci_demo_erp');
        $t->assert(!empty($cookie), "Expected 'ci_demo_erp' session cookie to be set");
        $t->assertNoPhpErrors($res['body']);
    });

    // TC-T1-02: Dashboard Loading with Active Session
    $runner->runTest("TC-T1-02", "Dashboard loads HTTP 200 with Sentral ERP branding", function (E2EHttpClient $http, E2ETestRunner $t) {
        $res = $http->get('/');
        $t->assertEquals(200, $res['statusCode'], "Dashboard request returned non-200 status");
        $t->assertContains('<title>Sentral ERP | Dashboard</title>', $res['body'], "Dashboard title missing or incorrect");
        $t->assertContains('iman', strtolower($res['body']), "Logged in user name missing from dashboard layout");
        $t->assertNoPhpErrors($res['body']);
    });

    // TC-T1-03: DataTables Server-Side JSON (Piutang Invoice)
    $runner->runTest("TC-T1-03", "DataTables Piutang Invoice returns valid server-side JSON", function (E2EHttpClient $http, E2ETestRunner $t) {
        $res = $http->get('/report_piutang_invoice/data?tanggal=2026-10-01&draw=1&start=0&length=10');
        $t->assertEquals(200, $res['statusCode'], "DataTables endpoint returned non-200 status");
        $t->assertNoPhpErrors($res['body']);

        $json = $t->assertValidJson($res['body']);
        $t->assertEquals(1, $json['draw'], "JSON draw mismatch");
        $t->assertGreaterThan(0, $json['recordsTotal'], "Expected positive recordsTotal count");
        $t->assert(isset($json['data']) && is_array($json['data']), "JSON envelope missing 'data' array");
        $t->assert(count($json['data']) <= 10, "Data size exceeds requested page length");
    });

    // TC-T1-04: DataTables Server-Side JSON (Progress PO)
    $runner->runTest("TC-T1-04", "DataTables Progress PO returns valid server-side JSON", function (E2EHttpClient $http, E2ETestRunner $t) {
        $endpoint = getProgressPoDataEndpoint($http);
        $res = $http->get($endpoint . '?start_date=2026-10-01&end_date=2026-10-31&draw=1&start=0&length=10');
        $t->assertEquals(200, $res['statusCode'], "DataTables Progress PO returned non-200 status");
        $t->assertNoPhpErrors($res['body']);

        $json = $t->assertValidJson($res['body']);
        $t->assert(isset($json['data']) && is_array($json['data']), "JSON envelope missing 'data' array");
        $t->assert(isset($json['recordsTotal']), "JSON envelope missing 'recordsTotal'");
    });

    // TC-T1-05: HTML2PDF (TCPDF Engine) Delivery Order PDF
    $runner->runTest("TC-T1-05", "HTML2PDF (TCPDF) generates valid %PDF- binary stream", function (E2EHttpClient $http, E2ETestRunner $t) {
        $res = $http->get('/wt_delivery_order/printDO/D2200001');
        $t->assertEquals(200, $res['statusCode'], "printDO endpoint returned non-200 status");
        $t->assertPdfValid($res['body'], 5000);
        $t->assert(str_starts_with($res['body'], "%PDF-1.7"), "HTML2PDF expected to produce PDF-1.7 header");
    });

    // TC-T1-06: mPDF Engine Delivery Order PDF
    $runner->runTest("TC-T1-06", "mPDF generates valid %PDF- binary stream", function (E2EHttpClient $http, E2ETestRunner $t) {
        $res = $http->get('/wt_delivery_order/print_do/D2200001');
        $t->assertEquals(200, $res['statusCode'], "print_do endpoint returned non-200 status");
        $t->assertPdfValid($res['body'], 10000);
        $t->assert(str_starts_with($res['body'], "%PDF-1.4"), "mPDF expected to produce PDF-1.4 header");
    });

    // TC-T1-07: PhpSpreadsheet Progress PO Excel Export
    $runner->runTest("TC-T1-07", "PhpSpreadsheet exports valid multi-sheet XLSX file", function (E2EHttpClient $http, E2ETestRunner $t) {
        $res = $http->get('/report_progress_po/export_excel?start_date=2026-10-01&end_date=2026-10-31');
        $t->assertEquals(200, $res['statusCode'], "Excel export returned non-200 status");
        $t->assertXlsxValid($res['body'], 2, ['Ringkasan', 'Data PO']);
    });
}

// =============================================================================
// TIER 2: Boundary & Corner Cases (Error Handling & Edge Cases)
// =============================================================================
if ($runner->shouldRunTier(2)) {
    $runner->printTierHeader(2, "Boundary & Corner Cases", "Validates input sanitization, unauthorized redirects, empty ranges, and missing entities");

    // TC-T2-01: Invalid Credentials Authentication
    $runner->runTest("TC-T2-01", "Invalid credentials rejection without active session", function (E2EHttpClient $http, E2ETestRunner $t) {
        $isolatedClient = new E2EHttpClient($http->getBaseUrl());
        $res = $isolatedClient->post('/login', [
            'login'    => '1',
            'username' => 'invalid_user_xyz',
            'password' => 'wrong_password_123',
        ]);

        if (in_array($res['statusCode'], [301, 302, 303, 307, 308], true)) {
            $t->assertRedirect($res, 'login');
        } else {
            $t->assertEquals(200, $res['statusCode'], "Unexpected status on failed login");
        }

        // Verify protected access fails
        $dashRes = $isolatedClient->get('/');
        $isBlocked = in_array($dashRes['statusCode'], [301, 302, 303, 307, 308], true) || strpos($dashRes['body'], 'Sentral ERP | Dashboard') === false;
        $t->assert($isBlocked, "Protected dashboard must not be accessible after failed authentication");
    });

    // TC-T2-02: Unauthenticated Direct Access Redirect (Dashboard)
    $runner->runTest("TC-T2-02", "Unauthenticated request to / redirects to /login", function (E2EHttpClient $http, E2ETestRunner $t) {
        $freshClient = new E2EHttpClient($http->getBaseUrl());
        $res = $freshClient->get('/');
        $t->assertRedirect($res, 'login', "Expected unauthenticated access to / to redirect to login");
    });

    // TC-T2-03: Unauthenticated Direct Access Redirect (Protected Module)
    $runner->runTest("TC-T2-03", "Unauthenticated request to protected module redirects to /login", function (E2EHttpClient $http, E2ETestRunner $t) {
        $freshClient = new E2EHttpClient($http->getBaseUrl());
        $res = $freshClient->get('/wt_delivery_order/delivery_order');
        $t->assertRedirect($res, 'login', "Expected unauthenticated module access to redirect to login");
    });

    // TC-T2-04: DataTables Query with Empty / Zero Records Date Range
    $runner->runTest("TC-T2-04", "DataTables query with zero-match date range handles cleanly", function (E2EHttpClient $http, E2ETestRunner $t) {
        $http->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);
        $endpoint = getProgressPoDataEndpoint($http);
        // Valid date range (>= 2000-01-01) where no PO records exist in DB
        $res = $http->get($endpoint . '?start_date=2001-01-01&end_date=2001-01-02&draw=1&start=0&length=10');

        $t->assertEquals(200, $res['statusCode'], "Zero-match query returned non-200");
        $t->assertNoPhpErrors($res['body']);
        $json = $t->assertValidJson($res['body']);
        $t->assertEquals(0, $json['recordsTotal'], "Expected 0 recordsTotal for historical date range");
        $t->assertEquals([], $json['data'], "Expected empty data array for zero records");
    });

    // TC-T2-05: Non-Existent Entity Delivery Order PDF (mPDF Engine)
    $runner->runTest("TC-T2-05", "Request for non-existent Delivery Order PDF handled without crash", function (E2EHttpClient $http, E2ETestRunner $t) {
        $http->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);
        $res = $http->get('/wt_delivery_order/print_do/NONEXISTENT_DO_99999');

        $t->assertEquals(200, $res['statusCode'], "mPDF returned non-200 status on non-existent DO");
        $t->assertPdfValid($res['body'], 5000);
        $t->assertNoPhpErrors($res['body']);
    });
}

// =============================================================================
// TIER 3: Cross-Feature Interactions (Session Integrity & Multi-Module)
// =============================================================================
if ($runner->shouldRunTier(3)) {
    $runner->printTierHeader(3, "Cross-Feature Interactions", "Validates session persistence across modules, DataTables pagination slicing, and logout");

    // TC-T3-01: Multi-Request Session Maintenance
    $runner->runTest("TC-T3-01", "Session persists across sequential multi-module requests", function (E2EHttpClient $http, E2ETestRunner $t) {
        $sessionClient = new E2EHttpClient($http->getBaseUrl());
        $loginRes = $sessionClient->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);
        $t->assertRedirect($loginRes, '/', "Login failed");

        $paths = [
            '/',
            '/report_piutang_invoice',
            '/report_progress_po',
            '/wt_delivery_order/delivery_order',
            '/users/setting',
        ];

        foreach ($paths as $path) {
            $res = $sessionClient->get($path);
            $t->assertEquals(200, $res['statusCode'], "Path $path failed with status {$res['statusCode']} under active session");
            $t->assertNoPhpErrors($res['body']);
        }
    });

    // TC-T3-02: DataTables Server-Side Pagination Slicing
    $runner->runTest("TC-T3-02", "DataTables server-side pagination slices distinct records", function (E2EHttpClient $http, E2ETestRunner $t) {
        $http->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);

        $page1Res = $http->get('/report_piutang_invoice/data?tanggal=2026-10-01&draw=1&start=0&length=10');
        $page2Res = $http->get('/report_piutang_invoice/data?tanggal=2026-10-01&draw=2&start=10&length=10');

        $json1 = $t->assertValidJson($page1Res['body']);
        $json2 = $t->assertValidJson($page2Res['body']);

        $t->assert(count($json1['data']) <= 10, "Page 1 count exceeds limit 10");
        $t->assert(count($json2['data']) <= 10, "Page 2 count exceeds limit 10");

        if ($json1['recordsTotal'] > 10 && !empty($json1['data']) && !empty($json2['data'])) {
            $t->assert($json1['data'][0] !== $json2['data'][0], "Page 1 and Page 2 first records must be distinct for proper pagination");
        }
    });

    // TC-T3-03: Clean Logout & Session Invalidation
    $runner->runTest("TC-T3-03", "Logout cleanly invalidates session and redirects to login", function (E2EHttpClient $http, E2ETestRunner $t) {
        $logoutClient = new E2EHttpClient($http->getBaseUrl());
        $loginRes = $logoutClient->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);
        $t->assertRedirect($loginRes, '/', "Login failed before logout test");

        $dashBefore = $logoutClient->get('/');
        $t->assertEquals(200, $dashBefore['statusCode'], "Session was not active before logout");

        // Execute logout
        $logoutRes = $logoutClient->get('/logout');
        $t->assertRedirect($logoutRes, 'login', "Expected redirect to login after logout");

        // Verify protected access is now blocked
        $dashAfter = $logoutClient->get('/');
        $t->assertRedirect($dashAfter, 'login', "Expected redirect when accessing dashboard after logout");
    });
}

// =============================================================================
// TIER 4: Real-World Scenarios (End-to-End Operational Lifecycle)
// =============================================================================
if ($runner->shouldRunTier(4)) {
    $runner->printTierHeader(4, "Real-World Scenarios", "Executes full multi-step manager operational cycle from login to export and teardown");

    // TC-T4-01: Full Manager Workflow End-to-End
    $runner->runTest("TC-T4-01", "Full Manager Workflow: Login -> Dashboard -> DataTables -> PDF -> Excel -> Logout", function (E2EHttpClient $http, E2ETestRunner $t) {
        $wfClient = new E2EHttpClient($http->getBaseUrl());

        // Step 1: Admin Login
        $s1 = $wfClient->post('/login', ['login' => '1', 'username' => 'iman', 'password' => 'iman']);
        $t->assertRedirect($s1, '/', "Step 1 (Login) failed");
        $t->assert(!empty($wfClient->getCookie('ci_demo_erp')), "Step 1: Session cookie missing");

        // Step 2: Access Dashboard
        $s2 = $wfClient->get('/');
        $t->assertEquals(200, $s2['statusCode'], "Step 2 (Dashboard) failed");
        $t->assertContains('<title>Sentral ERP | Dashboard</title>', $s2['body'], "Step 2: Dashboard title missing");
        $t->assertNoPhpErrors($s2['body']);

        // Step 3: Query Piutang Invoice DataTables
        $s3 = $wfClient->get('/report_piutang_invoice/data?tanggal=2026-10-01&draw=1&start=0&length=10');
        $t->assertEquals(200, $s3['statusCode'], "Step 3 (Piutang DataTables) failed");
        $json = $t->assertValidJson($s3['body']);
        $t->assertGreaterThan(0, $json['recordsTotal'], "Step 3: Expected active records");

        // Step 4: Issue Delivery Order PDF via HTML2PDF
        $s4 = $wfClient->get('/wt_delivery_order/printDO/D2200001');
        $t->assertEquals(200, $s4['statusCode'], "Step 4 (HTML2PDF printDO) failed");
        $t->assertPdfValid($s4['body'], 5000);

        // Step 5: Issue Delivery Order PDF via mPDF
        $s5 = $wfClient->get('/wt_delivery_order/print_do/D2200001');
        $t->assertEquals(200, $s5['statusCode'], "Step 5 (mPDF print_do) failed");
        $t->assertPdfValid($s5['body'], 10000);

        // Step 6: Export Progress PO Excel
        $s6 = $wfClient->get('/report_progress_po/export_excel?start_date=2026-10-01&end_date=2026-10-31');
        $t->assertEquals(200, $s6['statusCode'], "Step 6 (Excel export) failed");
        $t->assertXlsxValid($s6['body'], 2, ['Ringkasan', 'Data PO']);

        // Step 7: Clean Session Teardown
        $s7 = $wfClient->get('/logout');
        $t->assertRedirect($s7, 'login', "Step 7 (Logout) failed");

        $s8 = $wfClient->get('/');
        $t->assertRedirect($s8, 'login', "Step 7: Session still active after logout");
    });
}

// Exit with proper exit code (0 for PASS, 1 for FAIL)
exit($runner->printSummary());
