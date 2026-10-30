<?php
/**
 * Adversarial Empirical Verification Suite for Phase 4 (54 Active Modules Audit & Fix)
 * 
 * Verifies:
 * 1. docs/upgrade-php85-modules.json completeness (exactly 54 modules, all verified, valid directories)
 * 2. PHP 8.5 syntax linting across all PHP files in 54 active modules
 * 3. Surgical fix integrity:
 *    - Expense::transport_req_approve parameter deprecation fix
 *    - AllowDynamicProperties attribute on 5 standalone module libraries + Auth
 *    - Piutang_invoice_workbook null-coalescing safeguards
 * 4. Inactive modules classification
 * 5. Checkpoint execution (--phase=4 and --status)
 */

define('BASEPATH', true); // Bypass CI constant guard if needed

$root = dirname(__DIR__);
$modulesJsonPath = $root . '/docs/upgrade-php85-modules.json';
$modulesDir = $root . '/application/modules';

$results = [
    'tests_run' => 0,
    'tests_passed' => 0,
    'tests_failed' => 0,
    'failures' => [],
    'details' => []
];

function record_assert($description, $condition, $failureDetail = '') {
    global $results;
    $results['tests_run']++;
    if ($condition) {
        $results['tests_passed']++;
        echo "  [PASS] $description\n";
        $results['details'][] = ['name' => $description, 'status' => 'PASS'];
    } else {
        $results['tests_failed']++;
        echo "  [FAIL] $description: $failureDetail\n";
        $results['failures'][] = ['name' => $description, 'detail' => $failureDetail];
        $results['details'][] = ['name' => $description, 'status' => 'FAIL', 'detail' => $failureDetail];
    }
}

echo "======================================================================\n";
echo "ADVERSARIAL EMPIRICAL AUDIT: PHASE 4 (54 MODULES & PHP 8.5 SYNTAX)\n";
echo "Runtime PHP: " . PHP_VERSION . " (ID: " . PHP_VERSION_ID . ")\n";
echo "Timestamp  : " . date('Y-m-d H:i:s T') . "\n";
echo "======================================================================\n\n";

// --------------------------------------------------------------------
// SECTION 1: docs/upgrade-php85-modules.json Completeness & Schema Audit
// --------------------------------------------------------------------
echo "--- SECTION 1: docs/upgrade-php85-modules.json Completeness & Schema ---\n";

record_assert(
    "docs/upgrade-php85-modules.json exists",
    file_exists($modulesJsonPath),
    "File not found at $modulesJsonPath"
);

$rawJson = file_get_contents($modulesJsonPath);
$modulesData = json_decode($rawJson, true);

record_assert(
    "docs/upgrade-php85-modules.json is valid JSON",
    json_last_error() === JSON_ERROR_NONE && is_array($modulesData),
    json_last_error_msg()
);

$moduleKeys = array_keys($modulesData);
$totalModules = count($moduleKeys);

record_assert(
    "docs/upgrade-php85-modules.json contains exactly 54 modules",
    $totalModules === 54,
    "Expected 54 modules, found $totalModules"
);

$verifiedCount = 0;
$missingDirs = [];
$keyMismatches = [];
$nonVerified = [];

foreach ($modulesData as $key => $info) {
    if (($info['status'] ?? '') === 'verified') {
        $verifiedCount++;
    } else {
        $nonVerified[] = "$key (status: " . ($info['status'] ?? 'null') . ")";
    }

    if (($info['module'] ?? '') !== $key) {
        $keyMismatches[] = "Key '$key' does not match module field '" . ($info['module'] ?? '') . "'";
    }

    $modPath = $modulesDir . '/' . $key;
    if (!is_dir($modPath)) {
        $missingDirs[] = $key;
    }
}

record_assert(
    "All 54 modules have status 'verified'",
    $verifiedCount === 54 && count($nonVerified) === 0,
    "Found " . count($nonVerified) . " unverified modules: " . implode(', ', $nonVerified)
);

record_assert(
    "All JSON keys match internal 'module' attribute",
    count($keyMismatches) === 0,
    implode('; ', $keyMismatches)
);

record_assert(
    "Every module key corresponds to an existing directory in application/modules/",
    count($missingDirs) === 0,
    "Missing directories: " . implode(', ', $missingDirs)
);

// --------------------------------------------------------------------
// SECTION 2: Recursive Syntax Lint Audit (php -l) for all 54 Modules
// --------------------------------------------------------------------
echo "\n--- SECTION 2: PHP 8.5 Syntax Lint Audit Across 54 Active Modules ---\n";

$totalPhpFiles = 0;
$syntaxErrors = [];
$moduleFileCounts = [];

foreach ($moduleKeys as $moduleName) {
    $dir = $modulesDir . '/' . $moduleName;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    $countForModule = 0;
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $totalPhpFiles++;
            $countForModule++;
            $filePath = $file->getRealPath();

            $output = [];
            $exitCode = 0;
            // Execute php -l on the file
            exec("php -l " . escapeshellarg($filePath) . " 2>&1", $output, $exitCode);

            if ($exitCode !== 0) {
                $syntaxErrors[] = [
                    'file' => $filePath,
                    'module' => $moduleName,
                    'output' => implode("\n", $output)
                ];
            }
        }
    }
    $moduleFileCounts[$moduleName] = $countForModule;
}

record_assert(
    "Total PHP files across 54 modules discovered (> 500 files)",
    $totalPhpFiles >= 500,
    "Only discovered $totalPhpFiles files"
);

echo "  -> Audited $totalPhpFiles PHP files across 54 modules.\n";

record_assert(
    "PHP 8.5 syntax lint (php -l) reports ZERO syntax errors across all $totalPhpFiles files",
    count($syntaxErrors) === 0,
    "Found " . count($syntaxErrors) . " syntax errors: " . json_encode($syntaxErrors)
);

// --------------------------------------------------------------------
// SECTION 3: Surgical Fixes Audit
// --------------------------------------------------------------------
echo "\n--- SECTION 3: Surgical Fixes & Deprecation Audit ---\n";

// 3.1: Expense::transport_req_approve parameter order
$expenseControllerFile = $modulesDir . '/expense/controllers/Expense.php';
$expenseContent = file_get_contents($expenseControllerFile);
$hasDeprecatedSig = preg_match('/function\s+transport_req_approve\s*\(\s*\$id\s*=\s*[\'"][^\'"]*[\'"]\s*,\s*\$status\s*\)/', $expenseContent);
$hasFixedSig = preg_match('/function\s+transport_req_approve\s*\(\s*\$id\s*=\s*[\'"][^\'"]*[\'"]\s*,\s*\$status\s*=\s*null\s*\)/i', $expenseContent);

record_assert(
    "Expense::transport_req_approve does NOT declare optional param before required param",
    !$hasDeprecatedSig && $hasFixedSig,
    "Expense.php still contains deprecated signature or missing fix"
);

// 3.2: AllowDynamicProperties on standalone libraries
$standaloneLibs = [
    'Piutang_invoice_dataset' => $modulesDir . '/report_piutang_invoice/libraries/Piutang_invoice_dataset.php',
    'Piutang_invoice_workbook' => $modulesDir . '/report_piutang_invoice/libraries/Piutang_invoice_workbook.php',
    'Progress_po_rules' => $modulesDir . '/report_progress_po/libraries/Progress_po_rules.php',
    'Progress_po_workbook' => $modulesDir . '/report_progress_po/libraries/Progress_po_workbook.php',
    'Progress_so_workbook' => $modulesDir . '/report_progress_so/libraries/Progress_so_workbook.php',
    'Auth' => $modulesDir . '/users/libraries/Auth.php'
];

foreach ($standaloneLibs as $className => $filePath) {
    $content = file_get_contents($filePath);
    $hasAttribute = (strpos($content, '#[\AllowDynamicProperties]') !== false);
    record_assert(
        "Standalone library $className has #[\AllowDynamicProperties]",
        $hasAttribute,
        "$filePath is missing #[\AllowDynamicProperties]"
    );
}

// 3.3: Piutang_invoice_workbook null-coalescing safeguard
$workbookFile = $modulesDir . '/report_piutang_invoice/libraries/Piutang_invoice_workbook.php';
$workbookContent = file_get_contents($workbookFile);
$hasNullCoalesce = (
    strpos($workbookContent, "\$v['customer'] ?? ''") !== false &&
    strpos($workbookContent, "\$v['piutang_rekap'] ?? 0") !== false &&
    strpos($workbookContent, "\$v['piutang_invoice'] ?? 0") !== false
);

record_assert(
    "Piutang_invoice_workbook has null-coalescing safeguards on verification sheet rows",
    $hasNullCoalesce,
    "Missing null-coalesce in Piutang_invoice_workbook.php lines 74-78"
);

// --------------------------------------------------------------------
// SECTION 4: Checkpoint Script Empirical Execution
// --------------------------------------------------------------------
echo "\n--- SECTION 4: Checkpoint Script Empirical Execution ---\n";

$p4Output = [];
$p4Exit = 0;
exec("php " . escapeshellarg($root . '/scripts/verify_php85_checkpoint.php') . " --phase=4 2>&1", $p4Output, $p4Exit);
$p4Text = implode("\n", $p4Output);

record_assert(
    "scripts/verify_php85_checkpoint.php --phase=4 exits with code 0",
    $p4Exit === 0,
    "Exited with code $p4Exit. Output:\n$p4Text"
);

$cleanP4Text = preg_replace('/\033\[[0-9;]*m/', '', $p4Text);
record_assert(
    "scripts/verify_php85_checkpoint.php --phase=4 reports 'Hasil Fase 4: LULUS'",
    strpos($cleanP4Text, "Hasil Fase 4: LULUS") !== false,
    "Output did not indicate pass: $cleanP4Text"
);

$statusOutput = [];
$statusExit = 0;
exec("php " . escapeshellarg($root . '/scripts/verify_php85_checkpoint.php') . " --status 2>&1", $statusOutput, $statusExit);
$statusText = implode("\n", $statusOutput);

record_assert(
    "scripts/verify_php85_checkpoint.php --status exits with code 0",
    $statusExit === 0,
    "Exited with code $statusExit. Output:\n$statusText"
);

$cleanStatusText = preg_replace('/\033\[[0-9;]*m/', '', $statusText);
$allPhasesLulus = (
    strpos($cleanStatusText, "Hasil Fase 0: LULUS") !== false &&
    strpos($cleanStatusText, "Hasil Fase 1: LULUS") !== false &&
    strpos($cleanStatusText, "Hasil Fase 2: LULUS") !== false &&
    strpos($cleanStatusText, "Hasil Fase 3: LULUS") !== false &&
    strpos($cleanStatusText, "Hasil Fase 4: LULUS") !== false
);

record_assert(
    "scripts/verify_php85_checkpoint.php --status confirms Fase 0, 1, 2, 3, 4 ALL LULUS",
    $allPhasesLulus,
    "Status output missing one or more LULUS phases:\n$cleanStatusText"
);

// --------------------------------------------------------------------
// SECTION 5: Inactive Modules Sanity Check
// --------------------------------------------------------------------
echo "\n--- SECTION 5: Inactive Modules Sanity Audit ---\n";

$allModDirs = scandir($modulesDir);
$inactiveDirs = [];
foreach ($allModDirs as $item) {
    if ($item === '.' || $item === '..') continue;
    if (is_dir($modulesDir . '/' . $item) && !in_array($item, $moduleKeys, true)) {
        $inactiveDirs[] = $item;
    }
}

record_assert(
    "Inactive module directories detected and accounted for (legacy/backup modules)",
    count($inactiveDirs) > 0,
    "No inactive directories found"
);

echo "  -> Found " . count($inactiveDirs) . " inactive/legacy module directories outside active 54.\n";

// --------------------------------------------------------------------
// SUMMARY
// --------------------------------------------------------------------
echo "\n======================================================================\n";
echo "AUDIT SUMMARY:\n";
echo "Total Tests Run   : " . $results['tests_run'] . "\n";
echo "Total Tests Passed: " . $results['tests_passed'] . "\n";
echo "Total Tests Failed: " . $results['tests_failed'] . "\n";

if ($results['tests_failed'] === 0) {
    echo "\nVERDICT: [APPROVE] - All Phase 4 requirements and empirical stress tests passed cleanly.\n";
    echo "======================================================================\n";
    exit(0);
} else {
    echo "\nVERDICT: [CHALLENGE_FAILED] - Found " . $results['tests_failed'] . " failing checks.\n";
    echo "======================================================================\n";
    exit(1);
}
