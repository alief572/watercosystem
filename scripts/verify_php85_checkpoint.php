<?php
/**
 * scripts/verify_php85_checkpoint.php
 *
 * Verifikator checkpoint fase upgrade PHP 8.5 (watercosystem - CI 3.1.13 HMVC).
 * Dapat dijalankan dari host via:
 *   docker exec waterco_web85 php scripts/verify_php85_checkpoint.php --phase=0
 * atau:
 *   docker exec waterco_web85 php scripts/verify_php85_checkpoint.php --status
 */

$options = getopt('', ['phase:', 'status', 'help']);

if (isset($options['help'])) {
    echo "Usage: php scripts/verify_php85_checkpoint.php [--phase=0..5] [--status]\n";
    exit(0);
}

$phase = isset($options['phase']) ? (int) $options['phase'] : null;
$showStatus = isset($options['status']);

function color($text, $color = 'green') {
    $colors = ['green' => "\033[32m", 'red' => "\033[31m", 'yellow' => "\033[33m", 'cyan' => "\033[36m", 'reset' => "\033[0m"];
    return ($colors[$color] ?? '') . $text . ($colors['reset'] ?? '');
}

function check($desc, $pass, $detail = '') {
    if ($pass) {
        echo "  [" . color("PASS", "green") . "] $desc\n";
        return true;
    } else {
        echo "  [" . color("FAIL", "red") . "] $desc" . ($detail ? " ($detail)" : "") . "\n";
        return false;
    }
}

$docRoot = realpath(__DIR__ . '/..');

echo color("=== WATERCOSYSTEM PHP 8.5 CHECKPOINT VERIFIER ===", "cyan") . "\n";
echo "Runtime PHP Version : " . PHP_VERSION . " (ID: " . PHP_VERSION_ID . ")\n";
echo "Base Directory      : $docRoot\n";
echo "Timestamp           : " . date('Y-m-d H:i:s T') . "\n\n";

$allPassed = true;

// Helper: database connection check
function verifyDatabase() {
    $host = getenv('DB_HOST') ?: 'db';
    $user = getenv('DB_USER') ?: 'alief';
    $pass = getenv('DB_PASS') ?: 'sdk*^HkfJKjkefJFJLEJLE';
    $name = getenv('DB_NAME') ?: 'waterco_demo';
    $port = (int) (getenv('DB_PORT') ?: 3306);

    try {
        $mysqli = @new mysqli($host, $user, $pass, $name, $port);
        if ($mysqli->connect_errno) {
            return [false, $mysqli->connect_error];
        }
        $res = $mysqli->query("SELECT COUNT(*) as cnt FROM menus WHERE status = 1");
        $row = $res ? $res->fetch_assoc() : null;
        $cnt = $row ? $row['cnt'] : 0;
        $mysqli->close();
        return [true, "Connected to $host/$name ($cnt active menus)"];
    } catch (\Throwable $e) {
        return [false, $e->getMessage()];
    }
}

// Helper: HTTP check on localhost
function verifyHttp($path = '/', $expectedStatus = [200, 301, 302, 303, 307, 308]) {
    $url = "http://127.0.0.1" . $path;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close() is deprecated in PHP 8.5; GC closes handle automatically
    $pass = in_array($status, (array)$expectedStatus, true);
    return [$pass, "HTTP $status from $url"];
}

// -----------------------------------------------------------------------------
// CHECKPOINT LOGIC PER FASE
// -----------------------------------------------------------------------------

if ($phase === 0 || $showStatus) {
    echo color("[FASE 0: Environment PHP 8.5 & Infrastruktur Checkpoint]", "yellow") . "\n";
    $p0_1 = check("PHP Version >= 8.5.0", PHP_VERSION_ID >= 80500, "Detected: " . PHP_VERSION);
    
    $requiredExts = ['gd', 'mysqli', 'pdo_mysql', 'zip', 'intl', 'mbstring'];
    $missingExts = array_diff($requiredExts, get_loaded_extensions());
    $p0_2 = check("Ekstensi wajib PHP 8.5 aktif (" . implode(', ', $requiredExts) . ")", empty($missingExts), "Missing: " . implode(', ', $missingExts));
    
    list($dbPass, $dbMsg) = verifyDatabase();
    $p0_3 = check("Koneksi Database waterco_demo (DB_HOST=db)", $dbPass, $dbMsg);

    list($httpPass, $httpMsg) = verifyHttp('/', [200, 301, 302, 303, 307, 308]);
    list($loginPass, $loginMsg) = verifyHttp('/login', [200]);
    $p0_4 = check("Apache melayani HTTP request (root redirect & /login HTTP 200)", $httpPass && $loginPass, "$httpMsg, $loginMsg");

    $phase0Passed = $p0_1 && $p0_2 && $p0_3 && $p0_4;
    echo "Hasil Fase 0: " . ($phase0Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 0 && !$phase0Passed) $allPassed = false;
}

if ($phase === 1 || $showStatus) {
    echo color("[FASE 1: Audit Database menus & Matriks 54 Modul Aktif]", "yellow") . "\n";
    $jsonFile = "$docRoot/docs/upgrade-php85-modules.json";
    $jsonExists = file_exists($jsonFile);
    $p1_1 = check("File docs/upgrade-php85-modules.json ada", $jsonExists);
    
    $modCount = 0;
    if ($jsonExists) {
        $data = json_decode(file_get_contents($jsonFile), true);
        $modCount = is_array($data) ? count($data) : 0;
        $p1_2 = check("Matriks modul berisi 54 modul aktif", $modCount === 54, "Total: $modCount");
    } else {
        $p1_2 = check("Matriks modul berisi 54 modul aktif", false, "File belum dibuat");
    }

    $phase1Passed = $p1_1 && $p1_2;
    echo "Hasil Fase 1: " . ($phase1Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 1 && !$phase1Passed) $allPassed = false;
}

if ($phase === 2 || $showStatus) {
    echo color("[FASE 2: Composer Dependency & Shims Excel/PDF]", "yellow") . "\n";
    $hasAutoload = file_exists("$docRoot/vendor/autoload.php");
    if ($hasAutoload) {
        require_once "$docRoot/vendor/autoload.php";
    }
    if (!defined('FCPATH')) define('FCPATH', "$docRoot/");
    if (!defined('BASEPATH')) define('BASEPATH', "$docRoot/system/");
    if (!defined('APPPATH')) define('APPPATH', "$docRoot/application/");
    if (file_exists("$docRoot/application/libraries/Phpexcel_compat.php")) {
        require_once "$docRoot/application/libraries/Phpexcel_compat.php";
    }

    $p2_1 = check("Composer autoload aktif di root vendor", $hasAutoload);
    $p2_2 = check("Class Spreadsheet resolve", class_exists('\\PhpOffice\\PhpSpreadsheet\\Spreadsheet'));
    $p2_3 = check("Class Mpdf resolve", class_exists('\\Mpdf\\Mpdf'));
    $p2_4 = check("Class Html2Pdf resolve", class_exists('\\Spipu\\Html2Pdf\\Html2Pdf'));
    $p2_5 = check("Phpexcel_compat alias aktif", class_exists('PHPExcel'));

    $phase2Passed = $p2_1 && $p2_2 && $p2_3 && $p2_4 && $p2_5;
    echo "Hasil Fase 2: " . ($phase2Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 2 && !$phase2Passed) $allPassed = false;
}

if ($phase === 3 || $showStatus) {
    echo color("[FASE 3: Patch Bedah CI3 Core (system/) & Strict Deprecation Mode]", "yellow") . "\n";
    $commonPhp = file_get_contents("$docRoot/system/core/Exceptions.php");
    $strictGone = (strpos($commonPhp, "E_STRICT") === false || strpos($commonPhp, "PHP_VERSION_ID < 80400") !== false);
    $p3_1 = check("Core Exceptions aman dari E_STRICT deprecation di PHP 8.5", $strictGone);

    $sessionPhp = file_get_contents("$docRoot/system/libraries/Session/Session.php");
    $sessionAman = (strpos($sessionPhp, "PHP_VERSION_ID >= 80400") !== false || strpos($sessionPhp, "sid_regexp") !== false);
    $p3_2 = check("Session sid_length aman dari deprecation di PHP 8.5", $sessionAman);

    $phase3Passed = $p3_1 && $p3_2;
    echo "Hasil Fase 3: " . ($phase3Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 3 && !$phase3Passed) $allPassed = false;
}

if ($phase === 4 || $showStatus) {
    echo color("[FASE 4: Audit & Perbaikan 54 Modul Aktif]", "yellow") . "\n";
    $jsonFile = "$docRoot/docs/upgrade-php85-modules.json";
    $verifiedCount = 0;
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
        if (is_array($data)) {
            foreach ($data as $m) {
                if (($m['status'] ?? '') === 'verified') $verifiedCount++;
            }
        }
    }
    $p4_1 = check("Seluruh 54 modul aktif berstatus 'verified'", $verifiedCount === 54, "$verifiedCount / 54 verified");
    $phase4Passed = $p4_1;
    echo "Hasil Fase 4: " . ($phase4Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 4 && !$phase4Passed) $allPassed = false;
}

if ($phase === 5 || $showStatus) {
    echo color("[FASE 5: E2E Regresi & Promosi Docker Default]", "yellow") . "\n";
    $dockerfile = file_get_contents("$docRoot/docker/Dockerfile");
    $dockerDefault85 = (strpos($dockerfile, "FROM php:8.5-apache") !== false);
    $p5_1 = check("Default docker/Dockerfile menggunakan PHP 8.5", $dockerDefault85);
    $phase5Passed = $p5_1;
    echo "Hasil Fase 5: " . ($phase5Passed ? color("LULUS", "green") : color("BELUM LULUS", "red")) . "\n\n";
    if ($phase === 5 && !$phase5Passed) $allPassed = false;
}

if ($phase !== null) {
    exit($allPassed ? 0 : 1);
}
exit(0);
