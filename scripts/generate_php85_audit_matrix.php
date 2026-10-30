<?php
/**
 * scripts/generate_php85_audit_matrix.php
 *
 * Mengaudit database menus (waterco_demo) dan 54 modul aktif di bawah PHP 8.5,
 * lalu menghasilkan docs/upgrade-php85-modules.json.
 */

$host = getenv('DB_HOST') ?: 'db';
$user = getenv('DB_USER') ?: 'alief';
$pass = getenv('DB_PASS') ?: 'sdk*^HkfJKjkefJFJLEJLE';
$name = getenv('DB_NAME') ?: 'waterco_demo';
$port = (int) (getenv('DB_PORT') ?: 3306);

$mysqli = new mysqli($host, $user, $pass, $name, $port);
if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error . "\n");
}

$sidebarModules = [];
$res = $mysqli->query("SELECT id, title, link, group_menu, status FROM menus WHERE status = 1 AND group_menu = 1 AND link != '#' AND link != '' ORDER BY id ASC");
while ($row = $res->fetch_assoc()) {
    $rawLink = trim($row['link'], '/');
    $parts = explode('/', $rawLink);
    $mod = strtolower($parts[0]);
    if ($mod === 'adjustment stock retur') {
        $mod = 'adjustmentstockmulti';
    }
    if (!isset($sidebarModules[$mod])) {
        $sidebarModules[$mod] = [
            'titles' => [],
            'links' => []
        ];
    }
    $sidebarModules[$mod]['titles'][] = $row['title'];
    $sidebarModules[$mod]['links'][] = $row['link'];
}
$mysqli->close();

$crossModules = [
    'jurnal_nomor' => 'Helper model penomoran jurnal transaksi',
    'all' => 'Helper model global (All_model)',
    'pembayaran_rutin' => 'Modul endpoint finance/rutin',
    'customer' => 'Endpoint dan model transaksi customer',
    'penawaran' => 'Model inventory penawaran',
    'aktifitas' => 'Helper log aktifitas'
];

$allModules = [];

foreach ($sidebarModules as $mod => $info) {
    $allModules[$mod] = [
        'module' => $mod,
        'category' => 'menu_group_1',
        'menu_titles' => array_values(array_unique($info['titles'])),
        'menu_links' => array_values(array_unique($info['links'])),
        'description' => 'Sidebar menu aktif group 1'
    ];
}

foreach ($crossModules as $mod => $desc) {
    if (!isset($allModules[$mod])) {
        $allModules[$mod] = [
            'module' => $mod,
            'category' => 'cross_dependency',
            'menu_titles' => [],
            'menu_links' => [],
            'description' => $desc
        ];
    }
}

ksort($allModules);
echo "Total target modules: " . count($allModules) . "\n";

$matrix = [];
$docRoot = realpath(__DIR__ . '/..');

foreach ($allModules as $mod => $meta) {
    $modDir = "$docRoot/application/modules/$mod";
    $files = [];
    if (is_dir($modDir)) {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($modDir));
        foreach ($it as $f) {
            if ($f->isFile() && strtolower($f->getExtension()) === 'php') {
                $files[] = $f->getPathname();
            }
        }
    }

    $syntaxErrors = [];
    $deprecations = [];
    $hasMpdf = false;
    $hasHtml2pdf = false;
    $hasLibexcel = false;
    $hasPhpexcel = false;
    $hasDirectPhpSpreadsheet = false;

    foreach ($files as $filePath) {
        $rel = str_replace($docRoot . '/', '', $filePath);
        
        // 1. PHP 8.5 syntax lint
        $lintCmd = "php -l " . escapeshellarg($filePath) . " 2>&1";
        $lintOutput = shell_exec($lintCmd);
        if (strpos($lintOutput, 'No syntax errors detected') === false) {
            $syntaxErrors[] = [
                'file' => $rel,
                'error' => trim($lintOutput)
            ];
        }

        // 2. Static scan for patterns
        $content = file_get_contents($filePath);
        
        // PDF detection
        if (stripos($content, 'Mpdf') !== false || stripos($content, 'new mPDF') !== false) {
            $hasMpdf = true;
        }
        if (stripos($content, 'HTML2PDF') !== false) {
            $hasHtml2pdf = true;
        }

        // Excel detection
        if (stripos($content, 'Libexcel') !== false) {
            $hasLibexcel = true;
        }
        if (stripos($content, 'PHPExcel') !== false) {
            $hasPhpexcel = true;
        }
        if (stripos($content, 'PhpOffice\\PhpSpreadsheet') !== false) {
            $hasDirectPhpSpreadsheet = true;
        }

        // Deprecations / issues
        if (preg_match_all('/\(\s*(?:integer|boolean|double|binary)\s*\)/i', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'non_canonical_cast_85', 'count' => count($m[0])];
        }
        if (preg_match_all('/\bcase\s+[^:;]+;/', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'case_semicolon_85', 'count' => count($m[0])];
        }
        if (preg_match_all('/\$\{[a-zA-Z_]/', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'dollar_brace_82', 'count' => count($m[0])];
        }
        if (preg_match_all('/\beach\s*\(/i', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'each_removed_80', 'count' => count($m[0])];
        }
        if (preg_match_all('/\border_by\s*\([^,)]+,\s*(?:DESC|ASC)\s*\)/', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'bareword_order_by_80', 'count' => count($m[0])];
        }
        if (preg_match_all('/\b(?:imagedestroy|curl_close|xml_parser_free)\s*\(/i', $content, $m)) {
            $deprecations[] = ['file' => $rel, 'type' => 'deprecated_resource_fn_85', 'count' => count($m[0])];
        }
    }

    $pdfUsage = 'none';
    if ($hasMpdf && $hasHtml2pdf) $pdfUsage = 'mpdf+html2pdf';
    elseif ($hasMpdf) $pdfUsage = 'mpdf';
    elseif ($hasHtml2pdf) $pdfUsage = 'html2pdf';

    $excelUsage = 'none';
    if ($hasDirectPhpSpreadsheet) $excelUsage = 'phpspreadsheet_direct';
    elseif ($hasPhpexcel) $excelUsage = 'phpexcel_alias';
    elseif ($hasLibexcel) $excelUsage = 'libexcel';

    $matrix[$mod] = [
        'module' => $mod,
        'category' => $meta['category'],
        'description' => $meta['description'],
        'menu_titles' => $meta['menu_titles'],
        'menu_links' => $meta['menu_links'],
        'file_count' => count($files),
        'php85_syntax_errors' => $syntaxErrors,
        'php85_deprecations_static' => $deprecations,
        'pdf_usage' => $pdfUsage,
        'excel_usage' => $excelUsage,
        'status' => 'audited'
    ];

    echo "  - $mod: " . count($files) . " files, syntax errors: " . count($syntaxErrors) . ", deprecation patterns: " . count($deprecations) . ", PDF: $pdfUsage, Excel: $excelUsage\n";
}

$targetJson = "$docRoot/docs/upgrade-php85-modules.json";
file_put_contents($targetJson, json_encode($matrix, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "\nSaved audit matrix to: $targetJson (Total: " . count($matrix) . " modules)\n";
