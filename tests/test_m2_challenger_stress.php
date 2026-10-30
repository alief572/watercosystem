<?php
/**
 * Empirical Adversarial Challenger Test Suite: Milestone 2 (Phase 4)
 * Target Runtime: PHP 8.5.12 inside waterco_web85 container
 *
 * Test Focus:
 * 1. Expense::transport_req_approve parameter order & 0, 1, 2 argument invocation
 * 2. Dynamic property writes on 5 standalone module libraries
 * 3. Piutang_invoice_workbook missing array key offset safeguards & Excel export
 * 4. docs/upgrade-php85-modules.json 54-module verification matrix
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Global error collector
$captured_errors = [];
set_error_handler(function ($errno, $errstr, $errfile, $errline) use (&$captured_errors) {
    $errtypes = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
    ];
    $type = isset($errtypes[$errno]) ? $errtypes[$errno] : "UNKNOWN($errno)";
    $captured_errors[] = [
        'errno'   => $errno,
        'type'    => $type,
        'message' => $errstr,
        'file'    => $errfile,
        'line'    => $errline,
    ];
    return true; // prevent stdout clutter
}, E_ALL);

function clear_errors() {
    global $captured_errors;
    $errors = $captured_errors;
    $captured_errors = [];
    return $errors;
}

function get_errors() {
    global $captured_errors;
    return $captured_errors;
}

$total_tests = 0;
$passed_tests = 0;
$failed_tests = 0;
$failures = [];

function run_test($name, callable $fn) {
    global $total_tests, $passed_tests, $failed_tests, $failures;
    $total_tests++;
    clear_errors();
    echo "[TEST $total_tests] $name ... ";
    try {
        $fn();
        $errors = clear_errors();
        if (!empty($errors)) {
            $err_details = [];
            foreach ($errors as $e) {
                $err_details[] = "{$e['type']}: {$e['message']} in {$e['file']}:{$e['line']}";
            }
            throw new Exception("Unexpected PHP errors captured:\n  " . implode("\n  ", $err_details));
        }
        $passed_tests++;
        echo "PASS\n";
    } catch (Throwable $e) {
        $failed_tests++;
        $failures[] = [
            'test' => $name,
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ];
        echo "FAIL\n";
        echo "  Error: " . $e->getMessage() . "\n";
    }
}

echo "====================================================================\n";
echo "EMIRICAL ADVERSARIAL CHALLENGER SUITE: MILESTONE 2 (PHASE 4)\n";
echo "PHP Version: " . PHP_VERSION . " (Target: PHP 8.5.12)\n";
echo "====================================================================\n\n";

// SECTION 0: ORACLE SANITY CHECKS (Adversarial test harness validation)
echo "--- SECTION 0: ORACLE SANITY CHECKS ---\n";

run_test("Oracle: Error handler traps E_DEPRECATED on unannotated dynamic property", function() {
    clear_errors();
    $anon = new class {};
    $anon->dynamic_prop = 'val';
    $errors = clear_errors();
    $found_deprecated = false;
    foreach ($errors as $e) {
        if ($e['errno'] === E_DEPRECATED && strpos($e['message'], 'dynamic property') !== false) {
            $found_deprecated = true;
            break;
        }
    }
    if (!$found_deprecated) {
        throw new Exception("Oracle failure: Expected E_DEPRECATED on unannotated class dynamic property write!");
    }
});

run_test("Oracle: Error handler traps E_WARNING on undefined array key", function() {
    clear_errors();
    $arr = ['existing' => 1];
    $val = $arr['nonexistent'];
    $errors = clear_errors();
    $found_warning = false;
    foreach ($errors as $e) {
        if ($e['errno'] === E_WARNING && strpos($e['message'], 'Undefined array key') !== false) {
            $found_warning = true;
            break;
        }
    }
    if (!$found_warning) {
        throw new Exception("Oracle failure: Expected E_WARNING on undefined array key access!");
    }
});

run_test("Oracle: Parameter order deprecation reproduced on pre-patch signature (\$id='', \$status)", function() {
    clear_errors();
    eval('class PrePatchExpenseParamOrder { public function transport_req_approve($id="", $status) {} }');
    $errors = clear_errors();
    $found_deprecated = false;
    foreach ($errors as $e) {
        if ($e['errno'] === E_DEPRECATED && strpos($e['message'], 'implicitly treated as a required parameter') !== false) {
            $found_deprecated = true;
            break;
        }
    }
    if (!$found_deprecated) {
        throw new Exception("Oracle failure: Expected E_DEPRECATED on optional param before required param!");
    }
});

// SECTION 1: EXPENSE::TRANSPORT_REQ_APPROVE SIGNATURE AND INVOCATIONS
echo "\n--- SECTION 1: Expense::transport_req_approve STRESS TESTS ---\n";

// Bootstrap CI environment minimally for Expense controller
define('BASEPATH', '/var/www/html/system/');
define('APPPATH', '/var/www/html/application/');
define('VIEWPATH', '/var/www/html/application/views/');
define('FCPATH', '/var/www/html/');
define('ENVIRONMENT', 'development');
define('MB_ENABLED', true);
define('ICONV_ENABLED', true);

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_METHOD'] = 'GET';

require_once BASEPATH . 'core/Common.php';
if (file_exists('/var/www/html/vendor/autoload.php')) {
    require_once '/var/www/html/vendor/autoload.php';
}
require_once BASEPATH . 'core/Loader.php';
require_once BASEPATH . 'core/Controller.php';

if (!function_exists('get_instance')) {
    function &get_instance() {
        return CI_Controller::get_instance();
    }
}

// Pre-load CI core services needed by HMVC MX
$BM =& load_class('Benchmark', 'core');
$HOOK =& load_class('Hooks', 'core');
$CFG =& load_class('Config', 'core');
$UNI =& load_class('Utf8', 'core');
$URI =& load_class('URI', 'core');
$RTR =& load_class('Router', 'core');
$OUT =& load_class('Output', 'core');
$SEC =& load_class('Security', 'core');
$IN =& load_class('Input', 'core');
$LANG =& load_class('Lang', 'core');

require_once APPPATH . 'third_party/MX/Modules.php';
require_once APPPATH . 'third_party/MX/Controller.php';
require_once APPPATH . 'third_party/MX/Loader.php';
require_once APPPATH . 'core/MY_Loader.php';
require_once APPPATH . 'core/Base_Controller.php';
require_once APPPATH . 'core/Admin_Controller.php';

// Helper mock function simpan_aktifitas if not defined
if (!function_exists('simpan_aktifitas')) {
    function simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status) {
        return true;
    }
}

require_once APPPATH . 'modules/expense/controllers/Expense.php';

run_test("Expense::transport_req_approve Reflection parameter analysis", function() {
    $ref = new ReflectionClass(Expense::class);
    if (!$ref->hasMethod('transport_req_approve')) {
        throw new Exception("Method transport_req_approve not found in Expense");
    }
    $method = $ref->getMethod('transport_req_approve');
    $params = $method->getParameters();
    
    if (count($params) !== 2) {
        throw new Exception("Expected 2 parameters, got " . count($params));
    }
    
    $p0 = $params[0];
    if ($p0->getName() !== 'id' || !$p0->isOptional() || $p0->getDefaultValue() !== '') {
        throw new Exception("Param 0 must be optional \$id='' but got optional=" . ($p0->isOptional() ? 'true' : 'false') . ", default=" . var_export($p0->getDefaultValue(), true));
    }
    
    $p1 = $params[1];
    if ($p1->getName() !== 'status' || !$p1->isOptional() || $p1->getDefaultValue() !== null) {
        throw new Exception("Param 1 must be optional \$status=null but got optional=" . ($p1->isOptional() ? 'true' : 'false') . ", default=" . var_export($p1->getDefaultValue(), true));
    }
});

function create_mock_expense() {
    $ref = new ReflectionClass(Expense::class);
    $expense = $ref->newInstanceWithoutConstructor();
    
    // Wire required properties for transport_req_approve
    $expense->All_model = new class {
        public $last_table = null;
        public $last_data = null;
        public $last_where = null;
        public function dataUpdate($table, $data, $where) {
            $this->last_table = $table;
            $this->last_data = $data;
            $this->last_where = $where;
            return true;
        }
    };
    $expense->db = new class {
        public function last_query() {
            return "UPDATE tr_transport_req SET status='1' WHERE id='TR-001'";
        }
    };
    $expense->auth = new class {
        public function user_name() {
            return 'adversarial_tester';
        }
    };
    
    return $expense;
}

run_test("Expense::transport_req_approve invoked with 0 arguments", function() {
    $expense = create_mock_expense();
    
    ob_start();
    $expense->transport_req_approve();
    $output = ob_get_clean();
    
    $json = json_decode($output, true);
    if (!is_array($json)) {
        throw new Exception("Expected JSON output, got: " . $output);
    }
    if ($json['save'] !== false || $json['id'] !== 0) {
        throw new Exception("Expected save=false, id=0 for 0 args, got: " . json_encode($json));
    }
});

run_test("Expense::transport_req_approve invoked with 1 argument (\$id)", function() {
    $expense = create_mock_expense();
    
    ob_start();
    $expense->transport_req_approve('TR-CHALLENGE-01');
    $output = ob_get_clean();
    
    $json = json_decode($output, true);
    if (!is_array($json)) {
        throw new Exception("Expected JSON output, got: " . $output);
    }
    if ($json['save'] !== true || $json['id'] !== 'TR-CHALLENGE-01') {
        throw new Exception("Expected save=true, id='TR-CHALLENGE-01', got: " . json_encode($json));
    }
    if ($expense->All_model->last_data['status'] !== null) {
        throw new Exception("Expected status to be null in update data, got: " . var_export($expense->All_model->last_data['status'], true));
    }
});

run_test("Expense::transport_req_approve invoked with 2 arguments (\$id, status=1 finance)", function() {
    $expense = create_mock_expense();
    
    ob_start();
    $expense->transport_req_approve('TR-CHALLENGE-02', 1);
    $output = ob_get_clean();
    
    $json = json_decode($output, true);
    if (!is_array($json)) {
        throw new Exception("Expected JSON output, got: " . $output);
    }
    if ($json['save'] !== true || $json['id'] !== 'TR-CHALLENGE-02') {
        throw new Exception("Expected save=true, id='TR-CHALLENGE-02', got: " . json_encode($json));
    }
    if ($expense->All_model->last_data['fin_check_by'] !== 'adversarial_tester') {
        throw new Exception("Expected fin_check_by to be set to adversarial_tester");
    }
    if ($expense->All_model->last_data['approved_by'] !== 'adversarial_tester') {
        throw new Exception("Expected approved_by to be set to adversarial_tester");
    }
});

run_test("Expense::transport_req_approve invoked with 2 arguments (\$id, status=2 management)", function() {
    $expense = create_mock_expense();
    
    ob_start();
    $expense->transport_req_approve('TR-CHALLENGE-03', 2);
    $output = ob_get_clean();
    
    $json = json_decode($output, true);
    if (!is_array($json)) {
        throw new Exception("Expected JSON output, got: " . $output);
    }
    if ($json['save'] !== true || $json['id'] !== 'TR-CHALLENGE-03') {
        throw new Exception("Expected save=true, id='TR-CHALLENGE-03', got: " . json_encode($json));
    }
    if ($expense->All_model->last_data['management_by'] !== 'adversarial_tester') {
        throw new Exception("Expected management_by to be set to adversarial_tester");
    }
});

run_test("Expense::transport_req_approve invoked with 2 arguments (\$id, status=0 reset/reject)", function() {
    $expense = create_mock_expense();
    
    ob_start();
    $expense->transport_req_approve('TR-CHALLENGE-04', 0);
    $output = ob_get_clean();
    
    $json = json_decode($output, true);
    if (!is_array($json)) {
        throw new Exception("Expected JSON output, got: " . $output);
    }
    if ($json['save'] !== true || $json['id'] !== 'TR-CHALLENGE-04') {
        throw new Exception("Expected save=true, id='TR-CHALLENGE-04', got: " . json_encode($json));
    }
    if ($expense->All_model->last_data['status'] !== 0) {
        throw new Exception("Expected status to be 0, got: " . var_export($expense->All_model->last_data['status'], true));
    }
});

// SECTION 2: DYNAMIC PROPERTY WRITES ON 5 STANDALONE LIBRARIES
echo "\n--- SECTION 2: DYNAMIC PROPERTY WRITES ON STANDALONE LIBRARIES ---\n";

require_once APPPATH . 'modules/report_piutang_invoice/libraries/Piutang_invoice_dataset.php';
require_once APPPATH . 'modules/report_piutang_invoice/libraries/Piutang_invoice_workbook.php';
require_once APPPATH . 'modules/report_progress_po/libraries/Progress_po_rules.php';
require_once APPPATH . 'modules/report_progress_po/libraries/Progress_po_workbook.php';
require_once APPPATH . 'modules/report_progress_so/libraries/Progress_so_workbook.php';

$target_classes = [
    'Piutang_invoice_dataset',
    'Piutang_invoice_workbook',
    'Progress_po_rules',
    'Progress_po_workbook',
    'Progress_so_workbook',
];

foreach ($target_classes as $cls) {
    run_test("Dynamic Property writes on $cls under error_reporting(E_ALL)", function() use ($cls) {
        $ref = new ReflectionClass($cls);
        $attrs = $ref->getAttributes(AllowDynamicProperties::class);
        if (empty($attrs)) {
            throw new Exception("Class $cls does NOT have #[\AllowDynamicProperties] attribute!");
        }
        
        $obj = new $cls();
        
        // Write various types of dynamic properties
        $obj->dynamic_string = 'adversarial_property_value';
        $obj->dynamic_int = 424242;
        $obj->dynamic_float = 3.14159;
        $obj->dynamic_bool = true;
        $obj->dynamic_array = ['alpha' => 'beta', 100 => 200];
        $obj->dynamic_object = (object)['nested' => 'ok'];
        $obj->dynamic_null = null;
        
        // Assert values read back correctly
        if ($obj->dynamic_string !== 'adversarial_property_value' ||
            $obj->dynamic_int !== 424242 ||
            $obj->dynamic_array['alpha'] !== 'beta' ||
            $obj->dynamic_object->nested !== 'ok') {
            throw new Exception("Dynamic property value mismatch on $cls");
        }
    });
}

// SECTION 3: PIUTANG_INVOICE_WORKBOOK ARRAY OFFSET GUARD STRESS TESTS
echo "\n--- SECTION 3: PIUTANG_INVOICE_WORKBOOK ARRAY OFFSET SAFEGUARDS ---\n";

run_test("Piutang_invoice_workbook: Completely empty report and filters array", function() {
    $wb = new Piutang_invoice_workbook();
    $sheet = $wb->build([], []);
    if (!$sheet instanceof PhpOffice\PhpSpreadsheet\Spreadsheet) {
        throw new Exception("Expected Spreadsheet instance, got: " . get_class($sheet));
    }
});

run_test("Piutang_invoice_workbook: Invoices with missing keys (no customer, tgl, no_surat, nilai)", function() {
    $wb = new Piutang_invoice_workbook();
    $report = [
        'invoices' => [
            [], // missing every single key
            [
                'no_invoice' => 'INV-001',
                // customer missing
                // tgl_invoice missing
                // no_surat missing
                // nilai_invoice missing
                // sisa_piutang missing
                'payments' => [
                    [], // completely empty payment row
                    [
                        'kd_pembayaran' => 'PAY-001',
                        // tgl_pembayaran missing
                        // nilai_bayar missing
                        // total_bayar missing
                        // sisa_piutang missing
                    ]
                ]
            ]
        ],
        // total_piutang missing
        // verification missing
    ];
    $filters = [
        // tanggal missing
        // customer_id missing
        // no_invoice missing
    ];
    
    $sheet = $wb->build($report, $filters);
    if (!$sheet instanceof PhpOffice\PhpSpreadsheet\Spreadsheet) {
        throw new Exception("Expected Spreadsheet instance");
    }
});

run_test("Piutang_invoice_workbook: Verification array with missing keys (worker patched section)", function() {
    $wb = new Piutang_invoice_workbook();
    $report = [
        'verification' => [
            [], // missing 'customer', 'piutang_rekap', 'piutang_invoice'
            ['customer' => 'Customer With Missing Rekap & Invoice'], // missing numbers
            ['piutang_rekap' => 1500000], // missing customer and piutang_invoice
            ['piutang_invoice' => 2000000], // missing customer and piutang_rekap
            ['customer' => null, 'piutang_rekap' => null, 'piutang_invoice' => null], // explicit nulls
        ]
    ];
    $filters = ['tanggal' => '2026-10-31'];
    
    $sheet = $wb->build($report, $filters);
    if (!$sheet instanceof PhpOffice\PhpSpreadsheet\Spreadsheet) {
        throw new Exception("Expected Spreadsheet instance");
    }
    
    // Check sheet verification exists and has formatted cells
    $vSheet = $sheet->getSheetByName('Verifikasi');
    if ($vSheet === null) {
        throw new Exception("Sheet 'Verifikasi' was not created");
    }
    
    // Row 5: empty array -> should have empty string A5, 0 in B5, 0 in C5
    $a5 = $vSheet->getCell('A5')->getValue();
    $b5 = $vSheet->getCell('B5')->getValue();
    $c5 = $vSheet->getCell('C5')->getValue();
    if ($a5 !== '' || $b5 != 0 || $c5 != 0) {
        throw new Exception("Row 5 fallback mismatch: A5='$a5', B5='$b5', C5='$c5'");
    }
    
    // Row 6: customer set, numbers missing -> B6=0, C6=0
    $a6 = $vSheet->getCell('A6')->getValue();
    $b6 = $vSheet->getCell('B6')->getValue();
    $c6 = $vSheet->getCell('C6')->getValue();
    if ($a6 !== 'Customer With Missing Rekap & Invoice' || $b6 != 0 || $c6 != 0) {
        throw new Exception("Row 6 fallback mismatch: A6='$a6', B6='$b6', C6='$c6'");
    }
});

run_test("Piutang_invoice_workbook: Binary XLSX writer output stream integrity", function() {
    $wb = new Piutang_invoice_workbook();
    $report = [
        'invoices' => [
            ['customer' => 'PT Alpha', 'nilai_invoice' => 1000000, 'sisa_piutang' => 500000],
            ['customer' => 'PT Beta'], // partially empty
        ],
        'total_piutang' => 500000,
        'verification' => [
            ['customer' => 'PT Alpha', 'piutang_rekap' => 500000, 'piutang_invoice' => 500000],
            ['customer' => 'PT Missing Numbers'],
        ]
    ];
    $filters = ['tanggal' => '2026-10-31', 'customer_id' => '', 'no_invoice' => ''];
    $book = $wb->build($report, $filters);
    
    $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_stress_');
    try {
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($book);
        $writer->save($tmpFile);
        
        if (!file_exists($tmpFile) || filesize($tmpFile) === 0) {
            throw new Exception("XLSX output file is empty or was not created");
        }
        
        $handle = fopen($tmpFile, 'rb');
        $magic = fread($handle, 4);
        fclose($handle);
        
        // ZIP magic bytes: PK\x03\x04
        if ($magic !== "PK\x03\x04") {
            throw new Exception("Invalid magic bytes for XLSX: " . bin2hex($magic));
        }
    } finally {
        $book->disconnectWorksheets();
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }
    }
});

// SECTION 4: 54 MODULES MATRIX INTEGRITY
echo "\n--- SECTION 4: 54-MODULE MATRIX & CHECKPOINT VERIFIER ---\n";

run_test("Matrix docs/upgrade-php85-modules.json contains exactly 54 verified modules", function() {
    $matrix_path = '/var/www/html/docs/upgrade-php85-modules.json';
    if (!file_exists($matrix_path)) {
        throw new Exception("Matrix file does not exist: $matrix_path");
    }
    $raw = file_get_contents($matrix_path);
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        throw new Exception("Invalid JSON in $matrix_path");
    }
    if (count($data) !== 54) {
        throw new Exception("Expected 54 modules, got " . count($data));
    }
    
    $unverified = [];
    $missing_dirs = [];
    foreach ($data as $item) {
        if (!isset($item['status']) || $item['status'] !== 'verified') {
            $unverified[] = $item['module'] ?? 'unknown';
        }
        $dir = '/var/www/html/application/modules/' . ($item['module'] ?? '');
        if (!is_dir($dir)) {
            $missing_dirs[] = $item['module'] ?? 'unknown';
        }
    }
    
    if (!empty($unverified)) {
        throw new Exception("Found " . count($unverified) . " modules not verified: " . implode(', ', $unverified));
    }
    if (!empty($missing_dirs)) {
        throw new Exception("Found " . count($missing_dirs) . " modules with missing directory: " . implode(', ', $missing_dirs));
    }
});

echo "\n====================================================================\n";
echo "SUMMARY: Total: $total_tests | Passed: $passed_tests | Failed: $failed_tests\n";
echo "====================================================================\n";

if ($failed_tests > 0) {
    echo "TEST SUITE FAILED WITH $failed_tests FAILURES!\n";
    exit(1);
} else {
    echo "ALL EMPIRICAL ADVERSARIAL STRESS TESTS PASSED CLEANLY!\n";
    exit(0);
}
