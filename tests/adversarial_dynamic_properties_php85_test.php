<?php
/**
 * Adversarial Stress Test: Dynamic Properties Across CI3 Core, HMVC MX, Base Classes
 * Runtime Target: PHP 8.5.12 inside waterco_web85
 *
 * Requirements:
 * 1. Instantiate CI_Controller, MX_Controller, CI_Model, BF_Model, Base_Controller,
 *    Admin_Controller, Front_Controller, CI_Loader, MX_Loader, CI_DB_driver,
 *    CI_DB_mysqli_driver, Template, Auth.
 * 2. Dynamically assign arbitrary undeclared properties to each.
 * 3. Run under error_reporting(E_ALL) with custom error handler. Assert ZERO E_DEPRECATED.
 * 4. Test loading models and libraries via $this->load->model(...) and $this->load->library(...)
 *    on HMVC controllers.
 * 5. Determine if any subclass or dependency path was missed.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Global deprecation collector
$deprecations = [];
set_error_handler(function ($errno, $errstr, $errfile, $errline) use (&$deprecations) {
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
        $deprecations[] = [
            'errno'   => $errno,
            'type'    => ($errno === E_DEPRECATED ? 'E_DEPRECATED' : 'E_USER_DEPRECATED'),
            'message' => $errstr,
            'file'    => $errfile,
            'line'    => $errline,
        ];
        // Return true to avoid standard PHP error output interfering with CLI formatting
        return true;
    }
    return false;
}, E_ALL);

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

function &get_instance()
{
    return CI_Controller::get_instance();
}

// Pre-load CI core services to isolate dependency tests
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

// Load HMVC MX
require_once APPPATH . 'third_party/MX/Modules.php';
require_once APPPATH . 'third_party/MX/Controller.php';
require_once APPPATH . 'third_party/MX/Loader.php';

// Application core
require_once APPPATH . 'core/MY_Loader.php';
require_once APPPATH . 'core/Base_Controller.php';
require_once APPPATH . 'core/Admin_Controller.php';
require_once APPPATH . 'core/Front_Controller.php';

// Models
require_once BASEPATH . 'core/Model.php';
require_once APPPATH . 'core/BF_Model.php';

// Database drivers
require_once BASEPATH . 'database/DB_driver.php';
require_once BASEPATH . 'database/DB_query_builder.php';
if (!class_exists('CI_DB', false)) {
    class CI_DB extends CI_DB_query_builder {}
}
require_once BASEPATH . 'database/drivers/mysqli/mysqli_driver.php';

// Template & Auth
require_once APPPATH . 'libraries/Template.php';
require_once APPPATH . 'modules/users/libraries/Auth.php';

echo "====================================================================\n";
echo " ADVERSARIAL STRESS TEST: DYNAMIC PROPERTIES UNDER PHP " . PHP_VERSION . "\n";
echo "====================================================================\n\n";

// Record bootstrap deprecations (from loading/initializing core classes)
$bootstrapDeprecations = $deprecations;
$deprecations = []; // reset for test suites

echo "--- STEP 0: BOOTSTRAP DEPRECATION CHECK ---\n";
if (empty($bootstrapDeprecations)) {
    echo "[PASS] Zero deprecations during core framework bootstrap.\n\n";
} else {
    echo "[FAIL] " . count($bootstrapDeprecations) . " deprecation(s) detected during framework bootstrap:\n";
    foreach ($bootstrapDeprecations as $i => $d) {
        echo "  #" . ($i + 1) . " [{$d['type']}] {$d['message']} in {$d['file']}:{$d['line']}\n";
    }
    echo "\n";
}

// -----------------------------------------------------------------------------
// SUITE 1: 13 Required Target Classes Dynamic Property Stress Test
// -----------------------------------------------------------------------------
echo "--- SUITE 1: 13 REQUIRED TARGET CLASSES DYNAMIC PROPERTY ASSIGNMENT ---\n";

$targetClasses = [
    'CI_Controller',
    'MX_Controller',
    'CI_Model',
    'BF_Model',
    'Base_Controller',
    'Admin_Controller',
    'Front_Controller',
    'CI_Loader',
    'MX_Loader',
    'CI_DB_driver',
    'CI_DB_mysqli_driver',
    'Template',
    'Auth',
];

$suite1Results = [];

foreach ($targetClasses as $className) {
    if (!class_exists($className)) {
        $suite1Results[$className] = [
            'status' => 'FAIL',
            'reason' => 'Class does not exist',
            'deprecations' => 0,
        ];
        continue;
    }

    $ref = new ReflectionClass($className);
    $isAbstract = $ref->isAbstract();

    $instance = null;
    $instantiationMethod = '';

    if ($isAbstract) {
        // Concrete test subclass for abstract classes (CI_DB_driver)
        $subclassCode = "class Concrete_{$className} extends {$className} { public function __construct() {} }";
        if (!class_exists("Concrete_{$className}", false)) {
            eval($subclassCode);
        }
        $subclassName = "Concrete_{$className}";
        $instance = new $subclassName();
        $instantiationMethod = 'Concrete Subclass';
    } else {
        try {
            $instance = $ref->newInstanceWithoutConstructor();
            $instantiationMethod = 'Reflection newInstanceWithoutConstructor';
        } catch (\Throwable $e) {
            $suite1Results[$className] = [
                'status' => 'FAIL',
                'reason' => 'Failed instantiation: ' . $e->getMessage(),
                'deprecations' => 0,
            ];
            continue;
        }
    }

    $deprecationsBefore = count($deprecations);

    // Stress test: Assign multiple dynamic properties of various types
    $dynamicProps = [
        'dynamic_string_prop'   => 'Adversarial String ' . bin2hex(random_bytes(4)),
        'dynamic_int_prop'      => 987654321,
        'dynamic_float_prop'    => 3.1415926535,
        'dynamic_bool_prop'     => true,
        'dynamic_array_prop'    => ['a' => 1, 'b' => [2, 3, 4], 'nested' => ['deep' => true]],
        'dynamic_object_prop'   => (object)['key' => 'val', 'timestamp' => time()],
        'dynamic_null_prop'     => null,
    ];

    foreach ($dynamicProps as $prop => $val) {
        $instance->$prop = $val;
    }

    // Verify properties were stored correctly
    $verificationOk = true;
    foreach ($dynamicProps as $prop => $val) {
        if ($instance->$prop !== $val) {
            $verificationOk = false;
            break;
        }
    }

    // Unset and re-assign test
    unset($instance->dynamic_string_prop);
    $instance->dynamic_string_prop = 'Reassigned String';
    if ($instance->dynamic_string_prop !== 'Reassigned String') {
        $verificationOk = false;
    }

    $deprecationsAfter = count($deprecations);
    $newDeprecations = $deprecationsAfter - $deprecationsBefore;

    $hasAttr = count($ref->getAttributes(AllowDynamicProperties::class)) > 0;
    $parent = $ref->getParentClass();
    $inheritedAttr = false;
    while ($parent) {
        if (count($parent->getAttributes(AllowDynamicProperties::class)) > 0) {
            $inheritedAttr = true;
            break;
        }
        $parent = $parent->getParentClass();
    }

    if ($newDeprecations === 0 && $verificationOk) {
        $suite1Results[$className] = [
            'status' => 'PASS',
            'method' => $instantiationMethod,
            'direct_attr' => $hasAttr,
            'inherited_attr' => $inheritedAttr,
            'deprecations' => 0,
        ];
        echo sprintf(
            "  [PASS] %-22s: Dynamic assignment clean (Attr: %s, Inherited: %s)\n",
            $className,
            $hasAttr ? 'YES' : 'NO',
            $inheritedAttr ? 'YES' : 'NO'
        );
    } else {
        $suite1Results[$className] = [
            'status' => 'FAIL',
            'method' => $instantiationMethod,
            'direct_attr' => $hasAttr,
            'inherited_attr' => $inheritedAttr,
            'deprecations' => $newDeprecations,
        ];
        echo sprintf(
            "  [FAIL] %-22s: Deprecations: %d, Verification: %s\n",
            $className,
            $newDeprecations,
            $verificationOk ? 'OK' : 'MISMATCH'
        );
    }
}
echo "\n";

// -----------------------------------------------------------------------------
// SUITE 2: HMVC Loader ($this->load->model, $this->load->library) Dynamic Assignment
// -----------------------------------------------------------------------------
echo "--- SUITE 2: HMVC LOADER DYNAMIC PROPERTY ATTACHMENT ---\n";

class TestHmvcController extends MX_Controller
{
    public function __construct()
    {
        // Setup minimal mock controller environment
        $this->load = new MX_Loader();
        $this->load->initialize($this);
    }

    public function testLoadModel($modelName, $alias = null)
    {
        $this->load->model($modelName, $alias);
    }

    public function testLoadLibrary($libName, $params = null, $alias = null)
    {
        $this->load->library($libName, $params, $alias);
    }
}

$hmvcController = new TestHmvcController();

$deprecationsBeforeHmvc = count($deprecations);

// Test 1: Load a core/module model dynamically
echo "  Testing HMVC \$this->load->model('identitas_model')...\n";
$hmvcController->testLoadModel('identitas_model');
$modelAttached = isset($hmvcController->identitas_model) || isset(CI::$APP->identitas_model);
echo "    Attached to controller: " . ($modelAttached ? 'YES' : 'NO') . "\n";

// Test 2: Load model with alias
echo "  Testing HMVC \$this->load->model('identitas_model', 'custom_id_alias')...\n";
$hmvcController->testLoadModel('identitas_model', 'custom_id_alias');
$aliasAttached = isset($hmvcController->custom_id_alias) || isset(CI::$APP->custom_id_alias);
echo "    Attached with alias: " . ($aliasAttached ? 'YES' : 'NO') . "\n";

// Test 3: Load library dynamically (Template)
echo "  Testing HMVC \$this->load->library('Template')...\n";
$hmvcController->testLoadLibrary('Template');
$libAttached = isset($hmvcController->template) || isset(CI::$APP->template);
echo "    Attached to controller: " . ($libAttached ? 'YES' : 'NO') . "\n";

// Test 4: Load library with alias
echo "  Testing HMVC \$this->load->library('Template', null, 'custom_tpl')...\n";
$hmvcController->testLoadLibrary('Template', null, 'custom_tpl');
$libAliasAttached = isset($hmvcController->custom_tpl) || isset(CI::$APP->custom_tpl);
echo "    Attached with alias: " . ($libAliasAttached ? 'YES' : 'NO') . "\n";

$deprecationsAfterHmvc = count($deprecations);
$hmvcDeprecations = $deprecationsAfterHmvc - $deprecationsBeforeHmvc;

if ($hmvcDeprecations === 0 && $modelAttached && $libAttached) {
    echo "  [PASS] HMVC loader model/library dynamic attachment 100% deprecation-free.\n\n";
    $suite2Pass = true;
} else {
    echo "  [FAIL] HMVC loader triggered {$hmvcDeprecations} deprecation(s).\n\n";
    $suite2Pass = false;
}

// -----------------------------------------------------------------------------
// SUITE 3: Subclass Inheritance Stress Test
// -----------------------------------------------------------------------------
echo "--- SUITE 3: SUBCLASS INHERITANCE OF #[\AllowDynamicProperties] ---\n";

class Sub_CI_Controller extends CI_Controller {}
class Sub_MX_Controller extends MX_Controller {}
class Sub_Base_Controller extends Base_Controller {}
class Sub_Admin_Controller extends Admin_Controller {}
class Sub_Front_Controller extends Front_Controller {}
class Sub_CI_Model extends CI_Model {}
class Sub_BF_Model extends BF_Model {}
class Sub_CI_Loader extends CI_Loader {}
class Sub_MX_Loader extends MX_Loader {}

$subclasses = [
    'Sub_CI_Controller',
    'Sub_MX_Controller',
    'Sub_Base_Controller',
    'Sub_Admin_Controller',
    'Sub_Front_Controller',
    'Sub_CI_Model',
    'Sub_BF_Model',
    'Sub_CI_Loader',
    'Sub_MX_Loader',
];

$suite3Pass = true;
foreach ($subclasses as $subCls) {
    $ref = new ReflectionClass($subCls);
    $inst = $ref->newInstanceWithoutConstructor();
    $depBefore = count($deprecations);
    $inst->sub_dynamic_prop = 'sub_val';
    $depAfter = count($deprecations);

    if ($depAfter === $depBefore && $inst->sub_dynamic_prop === 'sub_val') {
        echo "  [PASS] Subclass {$subCls} cleanly inherited AllowDynamicProperties.\n";
    } else {
        echo "  [FAIL] Subclass {$subCls} emitted deprecation or failed assignment.\n";
        $suite3Pass = false;
    }
}
echo "\n";

// -----------------------------------------------------------------------------
// SUITE 4: Dependency Path & Core Class Completeness Audit
// -----------------------------------------------------------------------------
echo "--- SUITE 4: DEPENDENCY PATH & CORE CLASS COMPLETENESS AUDIT ---\n";

$coreClassesToCheck = [
    'CI_URI'       => 'system/core/URI.php',
    'CI_Router'    => 'system/core/Router.php',
    'MX_Router'    => 'application/third_party/MX/Router.php',
    'MY_Router'    => 'application/core/MY_Router.php',
    'CI_Security'  => 'system/core/Security.php',
    'CI_Output'    => 'system/core/Output.php',
    'CI_Input'     => 'system/core/Input.php',
    'CI_Lang'      => 'system/core/Lang.php',
    'CI_Config'    => 'system/core/Config.php',
    'CI_Benchmark' => 'system/core/Benchmark.php',
    'CI_Hooks'     => 'system/core/Hooks.php',
    'CI_Utf8'      => 'system/core/Utf8.php',
];

$missedClasses = [];

foreach ($coreClassesToCheck as $cls => $file) {
    if (!class_exists($cls)) {
        continue;
    }
    $ref = new ReflectionClass($cls);
    $inst = $ref->newInstanceWithoutConstructor();

    $depBefore = count($deprecations);
    $inst->probe_dynamic_property = 'probe_val';
    $depAfter = count($deprecations);

    $allowsDynamic = ($depAfter === $depBefore);
    $hasDirectAttr = count($ref->getAttributes(AllowDynamicProperties::class)) > 0;

    // Check if class has internal dynamic property assignments in its source code
    $source = file_get_contents('/var/www/html/' . $file);
    $hasInternalDynAssignment = false;
    $notes = [];

    if ($cls === 'CI_URI') {
        // Line 102: $this->config =& load_class('Config', 'core');
        if (!property_exists($cls, 'config')) {
            $notes[] = 'Assigns $this->config (undeclared property) in constructor';
            $hasInternalDynAssignment = true;
        }
    }
    if ($cls === 'CI_Router' || $cls === 'MX_Router' || $cls === 'MY_Router') {
        // Line 128: $this->uri =& load_class('URI', 'core');
        if (!property_exists($cls, 'uri')) {
            $notes[] = 'Assigns $this->uri (undeclared property) in constructor';
            $hasInternalDynAssignment = true;
        }
    }

    if (!$allowsDynamic && $hasInternalDynAssignment) {
        $missedClasses[$cls] = [
            'file' => $file,
            'notes' => implode(', ', $notes),
        ];
        echo "  [VULNERABILITY] {$cls} in {$file}: Lacks AllowDynamicProperties and {$notes[0]}.\n";
    } elseif (!$allowsDynamic) {
        echo "  [INFO] {$cls} in {$file}: Does not allow arbitrary dynamic properties (strict).\n";
    } else {
        echo "  [PASS] {$cls} in {$file}: Allows dynamic properties without deprecation.\n";
    }
}
echo "\n";

// -----------------------------------------------------------------------------
// SUMMARY & VERDICT
// -----------------------------------------------------------------------------
echo "====================================================================\n";
echo " FINAL EMPIRICAL RESULTS SUMMARY\n";
echo "====================================================================\n";

$suite1FailedCount = 0;
foreach ($suite1Results as $cls => $res) {
    if ($res['status'] !== 'PASS') {
        $suite1FailedCount++;
    }
}

echo "Suite 1 (13 Target Classes Dynamic Assignment): " . ($suite1FailedCount === 0 ? "PASSED (13/13)" : "FAILED ({$suite1FailedCount} failed)") . "\n";
echo "Suite 2 (HMVC Model/Library Loader): " . ($suite2Pass ? "PASSED" : "FAILED") . "\n";
echo "Suite 3 (Subclass AllowDynamicProperties Inheritance): " . ($suite3Pass ? "PASSED" : "FAILED") . "\n";
echo "Bootstrap Deprecations: " . count($bootstrapDeprecations) . "\n";
echo "Runtime Deprecations Trapped: " . count($deprecations) . "\n";
echo "Missed Core Classes with Dynamic Property Assignments: " . count($missedClasses) . "\n";

if (!empty($bootstrapDeprecations) || !empty($missedClasses)) {
    echo "\n>>> VERDICT: CHALLENGE_FAILED <<<\n";
    echo "Rationale: Framework core exhibits unhandled dynamic property deprecations during initialization under E_ALL.\n";
    echo "Specific missed paths:\n";
    foreach ($bootstrapDeprecations as $d) {
        echo " - [{$d['type']}] {$d['message']} in {$d['file']}:{$d['line']}\n";
    }
    foreach ($missedClasses as $cls => $info) {
        echo " - Missed class {$cls} ({$info['file']}): {$info['notes']}\n";
    }
    exit(1);
} else {
    echo "\n>>> VERDICT: APPROVE <<<\n";
    exit(0);
}
