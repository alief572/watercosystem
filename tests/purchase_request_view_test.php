<?php
// Run: php tests/purchase_request_view_test.php
ob_start(); require __DIR__ . '/purchase_request_test.php'; ob_end_clean();
function html_escape($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function base_url($path = '') { return '/' . ltrim($path, '/'); }
function has_permission($permission) { return strpos($permission, '.Manage') === false; }
function show_404() { throw new RuntimeException('Not found', 404); }
class Pr_view_db extends Pr_test_db {
    public $supplierCount = 2, $materialMissing = false;
    function query($sql, $binds = array()) {
        $sql = preg_replace('/\s+/', ' ', $sql);
        if (strpos($sql, 'FROM ms_inventory_category3') !== false) {
            $rows = $this->materialMissing ? array() : array(array('id_category3'=>'M1','nama'=>'<script>alert(1)</script>',
                'kode_barang'=>"K'&",'id_bentuk'=>'B2000004','alloy'=>'Alloy','bentuk'=>'Shape','hardness'=>'Hardness','nama_bentuk'=>'Shape','nm_bentuk'=>'Shape'));
        } elseif (strpos($sql, 'FROM master_supplier') !== false || strpos($sql, 'FROM child_inven_suplier') !== false) {
            $rows = array_slice(array(array('id_suplier'=>'S1','name_suplier'=>'Supplier 1','supname'=>'Supplier 1'),
                array('id_suplier'=>'S2','name_suplier'=>'<script>alert(1)</script>','supname'=>'<script>alert(1)</script>')), 0, $this->supplierCount);
        } elseif (strpos($sql, 'FROM dt_spkmarketing') !== false) $rows = array(array('id_material'=>'M1'));
        elseif (strpos($sql, 'FROM child_inven_dimensi') !== false) $rows = array();
        else return parent::query($sql, $binds);
        return new Pr_test_result($rows);
    }
}
class Pr_view_fixture {
    public $db, $uri;
    function __construct() { $this->db = new Pr_view_db(); $this->uri = $this; }
    function segment($index) { return $index === 1 ? 'purchase_request' : 'SPK1'; }
    function render($name, $results) {
        ob_start();
        try { require dirname(__DIR__) . '/application/modules/purchase_request/views/' . $name . '.php'; return ob_get_contents(); }
        finally { ob_end_clean(); }
    }
}
function pr_dom($html) {
    $previous = libxml_use_internal_errors(true);
    try { $dom = new DOMDocument(); $dom->loadHTML($html); return new DOMXPath($dom); }
    finally { libxml_clear_errors(); libxml_use_internal_errors($previous); }
}
$fixture = new Pr_view_fixture();
$header = (object)array_replace($original, array('requestor'=>'<script>alert(1)</script>'));
$detail = (object)array('no_pr'=>$header->no_pr, 'id_dt_pr'=>$header->no_pr.'-7','idmaterial'=>'M1',
    'nama'=>'<script>alert(1)</script>','nama_material'=>'Stored material','kode_barang'=>"K'&",'bentuk'=>'Shape','id_bentuk'=>'B2000004',
    'idameter'=>400,'odameter'=>0,'qty'=>1,'weight'=>0,'totalweight'=>0,'width'=>0,'length'=>0,'suplier'=>'S1',
    'name_suplier'=>'Stored supplier','tanggal'=>'2026-12-01','keterangan'=>"Quote ' & <tag>");
foreach (array('index','index_approval') as $view) {
    foreach (array(array(),array($header)) as $records) {
        $html = $fixture->render($view, $records); $xpath = pr_dom($html);
        pr_check(strpos($html, '/purchase_request/add') !== false, "$view Create link works without a record");
        if ($records) {
            pr_check($xpath->query('//table[@id="example1"]/thead/tr/th')->length === $xpath->query('//table[@id="example1"]/tbody/tr/td')->length, "$view header/body columns match without Manage permission");
            pr_check(strpos($html, '&lt;script&gt;alert(1)&lt;/script&gt;') !== false, "$view escapes requestor");
        }
    }
}
$html = $fixture->render('Edit', array('head'=>array($header),'detail'=>array($detail)));
$xpath = pr_dom($html);
pr_check($xpath->query('//select[@id="dt_idameter_1"]/option[@selected]')->item(0)->getAttribute('value') === '400', 'Edit retains stored diameter');
pr_check($xpath->query('//input[@name="dt[1][id_dt_pr]"]')->item(0)->getAttribute('value') === $detail->id_dt_pr, 'Edit posts stable detail identity');
pr_check($xpath->query('//input[@id="dt_kodeproduk_1"]')->item(0)->getAttribute('value') === "K'&", 'Quotes survive attribute escaping');
pr_check(strpos($html, '<script>alert(1)</script>') === false, 'Edit escapes stored text and master labels');
$html = $fixture->render('View', array('header'=>array($header),'detail'=>array($detail)));
pr_check(strpos($html, 'Stored supplier') !== false && strpos($html, '&lt;script&gt;alert(1)&lt;/script&gt;') !== false, 'Detail renders escaped joined/snapshot data without master queries');
foreach (array(0,1,2) as $supplierCount) {
    $fixture->db->supplierCount = $supplierCount;
    $html = $fixture->render('Addpr', array()); $xpath = pr_dom($html);
    pr_check($xpath->query('//select[@id="dt_suplier_1"]/option')->length === $supplierCount+1, 'Planning renders all suppliers, including zero: ' . $supplierCount);
    pr_check(strpos($html, '<script>alert(1)</script>') === false, 'Planning escapes labels with missing dimensions');
}
$fixture->db->materialMissing = true;
$fixture->render('Addpr', array());
pr_check(true, 'Planning handles missing master material without warnings');
$controller->db = new Pr_view_db(); $controller->input->values = array('jumlah'=>'3');
foreach (array('0'=>7,'1'=>10) as $planning=>$visible) {
    $controller->input->values['planning'] = (string)$planning;
    ob_start(); $controller->AddMaterial(); $html = ob_get_clean();
    $xpath = pr_dom('<table>'.$html.'</table>');
    pr_check($xpath->query('//tr[@id="tr_4"]/td[not(@hidden)]')->length === $visible, 'New row matches visible fields for planning=' . $planning);
}
foreach (array('CariBentuk','CariIdBentuk','CariKodeproduk','HitungTwight','CariSupplier','AddMaterial') as $method) {
    $controller->input->values = array('id'=>"1' onmouseover='bad",'jumlah'=>'bad','idmaterial'=>'M1');
    ob_start(); $controller->$method(); $html = ob_get_clean();
    pr_check($html === '' && $controller->output->status === 422, $method . ' rejects injected row identifiers');
}
echo "Purchase request view checks passed.\n";
