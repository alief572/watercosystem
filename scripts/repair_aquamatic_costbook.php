<?php
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';

function aquamaticEvaluate($source, $basis = 'reconstructed')
{
    $result = array('ready'=>false,'proposed_costbook'=>null,'reason'=>'');
    try {
        if (count($source['products']) !== 1 || count($source['stock']) !== 1) { throw new DomainException('Master barang/stok utama tidak tunggal.'); }
        if ($source['other_stock']) { throw new DomainException('Stok gudang lain perlu direkonsiliasi terlebih dahulu.'); }
        if (count($source['master']) > 1) { throw new DomainException('Master costbook ganda.'); }
        $material = $source['products'][0]['id_category3'];
        $receipts = $poTotals = $dates = array();
        foreach ($source['receipts'] as $receipt) {
            $qty = Stock_booking_rules::quantity($receipt['qty_recive']);
            $price = Stock_booking_store::amount($receipt['harga_satuan_usd']);
            $rate = Stock_booking_store::amount($receipt['kurs']);
            $value = Stock_booking_store::amount($receipt['harga_total_idr']);
            if (!$qty || $price <= 0 || $rate <= 0 || $value <= 0 || abs(round($qty*$price*$rate,2)-$value) > 0.01) { throw new DomainException('Qty/harga/kurs/nilai Incoming tidak konsisten.'); }
            $headers = array_values(array_filter($source['headers'], function ($h) use ($receipt) { return $h['id_data'] === $receipt['id_data'] && $h['id_incoming'] === $receipt['id_incoming']; }));
            $pos = array_values(array_filter($source['pos'], function ($po) use ($receipt) { return $po['id_dt_po'] === $receipt['id_dt_po']; }));
            if (count($headers) !== 1 || (float)$headers[0]['kurs'] !== $rate || (strtolower($headers[0]['matauang']) === 'idr' && $rate !== 1.0)
                || count($pos) !== 1 || $pos[0]['idmaterial'] !== $material || abs(Stock_booking_store::amount($pos[0]['hargasatuan'])-$price) > 0.0001) { throw new DomainException('Sumber PO/header/kurs Incoming tidak dapat diverifikasi.'); }
            $poTotals[$receipt['id_dt_po']] = ($poTotals[$receipt['id_dt_po']] ?? 0) + $qty;
            if ($poTotals[$receipt['id_dt_po']] > Stock_booking_rules::quantity($pos[0]['qty'])) { throw new DomainException('Riwayat penerimaan melebihi Qty PO.'); }
            $key = $receipt['id_incoming'];
            if (!isset($receipts[$key])) { $receipts[$key] = array('qty'=>0,'value'=>0,'used'=>false); }
            $receipts[$key]['qty'] += $qty; $receipts[$key]['value'] += $value;
            if ($basis === 'latest-incoming') {
                $date = DateTimeImmutable::createFromFormat('!Y-m-d', $headers[0]['tanggal'] ?? '');
                if (!$date || $date->format('Y-m-d') !== $headers[0]['tanggal']) { throw new DomainException('Tanggal Incoming tidak valid.'); }
                $dates[$key] = array($headers[0]['tanggal'], $headers[0]['created_date'] ?? '');
            }
        }
        if ($basis === 'latest-incoming') {
            if (!$dates) { throw new DomainException('Incoming terakhir tidak tersedia.'); }
            arsort($dates);
            $keys = array_keys($dates);
            if (count($keys) > 1 && $dates[$keys[0]] === $dates[$keys[1]]) { throw new DomainException('Urutan Incoming terakhir ambigu; periksa dokumen terlebih dahulu.'); }
            $key = $keys[0]; $receipt = $receipts[$key];
            $cost = round($receipt['value'] / $receipt['qty'], 2);
            if ($cost <= 0) { throw new DomainException('Harga Incoming terakhir tidak valid.'); }
            if ($source['master'] && (float)$source['master'][0]['nilai_costbook'] !== $cost) { throw new DomainException('Master sudah terisi dengan nilai berbeda; tidak ditimpa.'); }
            return array('ready'=>true,'proposed_costbook'=>$cost,
                'source_incoming'=>array('number'=>$key,'date'=>$dates[$key][0],'qty'=>$receipt['qty'],'value_idr'=>$receipt['value']),
                'reason'=>'HPP pengganti dari nilai barang IDR / qty Incoming terakhir, tanpa PPN; bukan rekonstruksi HPP historis.');
        }
        if (!$source['cards']) { throw new DomainException('Riwayat kartu stok kosong.'); }
        $qty = Stock_booking_rules::quantity($source['cards'][0]['qty']);
        $cost = 0.0;
        if ($qty !== 0) {
            $opening = $source['opening'] ?? array();
            if (!$opening) { throw new DomainException('Nilai persediaan awal tidak tersedia; riwayat tidak dimulai dari stok nol.'); }
            if (!is_array($opening) || Stock_booking_rules::quantity($opening['qty'] ?? null) !== $qty
                || ($opening['as_of'] ?? '') !== substr($source['cards'][0]['created_on'],0,10)
                || !is_string($opening['source'] ?? null) || trim($opening['source']) === '' || strlen($opening['source']) > 500
                || !is_string($opening['verified_by'] ?? null) || !preg_match('/^[A-Za-z0-9_.@-]{1,50}$/D',$opening['verified_by'])) { throw new DomainException('Bukti saldo awal harus memuat qty, tanggal kartu pertama, sumber, dan pemeriksa finance yang valid.'); }
            $cost = round(Stock_booking_store::amount($opening['costbook'] ?? null),2);
            if ($cost <= 0) { throw new DomainException('HPP awal terverifikasi harus lebih dari nol.'); }
        }
        foreach ($source['cards'] as $card) {
            if ((string)($card['deleted'] ?? '0') === '1') { throw new DomainException('Ada kartu stok dihapus; perlu rekonsiliasi manual.'); }
            $before = Stock_booking_rules::quantity($card['qty']);
            $after = Stock_booking_rules::quantity($card['qty_akhir']);
            if ($before !== $qty) { throw new DomainException('Rangkaian saldo kartu stok tidak tersambung pada ID ' . $card['id_kartu_stok']); }
            $delta = $after - $before;
            if ($delta !== 0 && abs($delta) !== Stock_booking_rules::quantity($card['qty_transaksi'])) { throw new DomainException('Qty mutasi kartu stok tidak konsisten.'); }
            if ($delta > 0) {
                $key = $card['no_transaksi']; $receipt = $receipts[$key] ?? null;
                if (!in_array($card['transaksi'], array('incoming','stock in'), true) || !$receipt || $receipt['used'] || $receipt['qty'] !== $delta
                    || abs(Stock_booking_store::amount($card['harga_do'])-$receipt['value']) > 0.01) { throw new DomainException('Mutasi masuk belum memiliki sumber biaya yang cocok: ' . $key); }
                $cost = round(($before*$cost + $receipt['value'])/$after, 2);
                $receipts[$key]['used'] = true;
            }
            $qty = $after;
        }
        foreach ($receipts as $receipt) { if (!$receipt['used']) { throw new DomainException('Ada detail Incoming tanpa mutasi stok yang terverifikasi.'); } }
        if ($qty !== Stock_booking_rules::quantity($source['stock'][0]['qty']) || $cost <= 0) { throw new DomainException('Saldo akhir/nilai persediaan belum cocok dengan stok saat ini.'); }
        if ($source['master'] && (float)$source['master'][0]['nilai_costbook'] !== $cost) { throw new DomainException('Master sudah terisi dengan nilai berbeda; tidak ditimpa.'); }
        $result = array('ready'=>true,'proposed_costbook'=>$cost,'reason'=>$source['master'] ? 'Master sudah sesuai; tidak ada perubahan.' : 'Sumber Incoming dan saldo akhir cocok; periksa bukti saldo awal bila digunakan.');
    } catch (DomainException $error) { $result['reason'] = $error->getMessage(); }
    return $result;
}

function aquamaticPreview(Stock_booking_store $store, $locking = false, $opening = array(), $basis = 'reconstructed')
{
    if (!in_array($basis, array('reconstructed','latest-incoming'), true)) { throw new DomainException('Basis pemulihan tidak valid.'); }
    if ($basis === 'latest-incoming' && $opening) { throw new DomainException('Harga Incoming terakhir tidak memakai bukti saldo awal.'); }
    if (!is_array($opening) || array_diff(array_keys($opening),array('LVL41431','LVL41432'))) { throw new DomainException('Bukti saldo awal hanya untuk dua Aquamatic.'); }
    $report = array('version'=>1,'basis'=>$basis,'opening_evidence'=>$opening,'items'=>array());
    $lock = $locking ? ' FOR UPDATE' : '';
    foreach (array('LVL41431','LVL41432') as $id) {
        $source = array();
        $queries = array(
            'products'=>'SELECT id_category3,nama,kode_barang,deleted FROM ms_inventory_category3 WHERE id_category3=? AND COALESCE(deleted,0)=0',
            'master'=>'SELECT id,id_category3,nilai_costbook FROM ms_costbook WHERE id_category3=? ORDER BY id',
            'stock'=>"SELECT id_stock,id_gudang,qty,qty_book,qty_free FROM stock_material WHERE id_category3=? AND id_gudang='1' AND COALESCE(deleted,0)=0 ORDER BY id_stock",
            // ponytail: Recovery supports the main warehouse; reconcile other warehouse stock before extending it.
            'other_stock'=>"SELECT id_stock,id_gudang,qty FROM stock_material_multigudang WHERE id_category3=? AND qty<>0 AND COALESCE(deleted,0)=0 ORDER BY id_stock",
            'cards'=>"SELECT id_kartu_stok,id_category3,qty,qty_akhir,qty_transaksi,transaksi,no_transaksi,created_on,harga_do,cost_book,deleted FROM kartu_stok WHERE id_category3=? AND id_gudang='1' ORDER BY created_on,id_kartu_stok",
            'receipts'=>'SELECT id_dt_incoming,id_data,id_incoming,id_dt_po,id_material,qty_recive,harga_satuan_usd,harga_total_idr,kurs FROM dt_incoming WHERE id_material=? ORDER BY id_dt_incoming',
            'pos'=>'SELECT id_dt_po,no_po,idmaterial,qty,hargasatuan FROM dt_trans_po WHERE idmaterial=? ORDER BY id_dt_po',
            'headers'=>'SELECT id_data,id_incoming,tanggal,created_date,kurs,matauang FROM tr_incoming WHERE id_data IN (SELECT id_data FROM dt_incoming WHERE id_material=?) ORDER BY id_data',
            'missing_hpp_do'=>'SELECT id_do_detail,no_do,qty_do,cost_book FROM tr_delivery_order_detail WHERE id_category3=? AND (cost_book IS NULL OR cost_book<=0) ORDER BY id_do_detail',
        );
        foreach ($queries as $key=>$sql) { $source[$key] = $store->query($sql . $lock, array($id)); }
        $source['opening'] = $opening[$id] ?? array();
        $source['basis'] = $basis;
        $evaluation = aquamaticEvaluate($source, $basis);
        $master = $source['master']; unset($source['master']);
        $openingCard = $source['cards'] ? array_intersect_key($source['cards'][0],array_flip(array('id_kartu_stok','qty','created_on','no_transaksi'))) : null;
        $report['items'][$id] = array_merge(array('name'=>$source['products'][0]['nama'] ?? $id,'stock'=>$source['stock'],'master'=>$master,'opening_card'=>$openingCard,
            'source_hash'=>hash('sha256',json_encode($source,JSON_THROW_ON_ERROR)),'missing_hpp_do'=>$source['missing_hpp_do']), $evaluation);
    }
    return $report;
}

function aquamaticApply(Stock_booking_store $store, $approved)
{
    $ids = array('LVL41431','LVL41432');
    $engine = $store->query("SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='ms_costbook'");
    if (count($engine) !== 1 || $engine[0]['ENGINE'] !== 'InnoDB') { throw new DomainException('Pemulihan memerlukan ms_costbook InnoDB.'); }
    if (($approved['version'] ?? null) !== 1 || array_keys($approved['items'] ?? array()) !== $ids) { throw new DomainException('Format preview tidak valid.'); }
    foreach ($ids as $id) { $store->costbook($id); }
    $basis = $approved['basis'] ?? 'reconstructed';
    $fresh = aquamaticPreview($store, true, $approved['opening_evidence'] ?? array(), $basis);
    foreach ($ids as $id) {
        $item = $fresh['items'][$id]; $old = $approved['items'][$id];
        if (!$item['ready'] || empty($old['ready'])) { throw new DomainException('Pemulihan diblokir untuk ' . $id . ': ' . $item['reason']); }
        if (!is_string($old['source_hash'] ?? null) || !hash_equals($item['source_hash'],$old['source_hash']) || (float)$old['proposed_costbook'] !== $item['proposed_costbook']) { throw new DomainException('Data berubah sejak preview; buat preview baru.'); }
    }
    $changed = array();
    foreach ($ids as $id) {
        $item = $fresh['items'][$id];
        if (!$item['master']) {
            $store->query('INSERT INTO ms_costbook(id_category3,nilai_costbook,created_on,created_by) VALUES (?,?,NOW(),?)', array($id,$item['proposed_costbook'],$approved['actor']));
            $saved = $store->costbook($id);
            if (count($saved) !== 1 || (float)$saved[0]['nilai_costbook'] !== $item['proposed_costbook']) { throw new RuntimeException('Pemulihan costbook tidak tersimpan.'); }
            $changed[] = $id;
        }
    }
    return array('changed'=>$changed,'before'=>$fresh,'after'=>aquamaticPreview($store,true,$approved['opening_evidence'] ?? array(),$basis));
}

if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== __FILE__) { return; }
$options = getopt('', array('preview','apply','preview-file:','opening-file:','basis:','actor:','environment:','help'));
if (isset($options['help'])) {
    echo "Preview (read only): php scripts/repair_aquamatic_costbook.php --preview > preview.json\n",
        "Optional finance evidence: add --opening-file=verified-opening.json to preview.\n",
        "Replacement HPP from latest Incoming: add --basis=latest-incoming to preview.\n",
        "Apply verified preview: php scripts/repair_aquamatic_costbook.php --apply --preview-file=preview.json --actor=USER_ID\n",
        "Only LVL41431/LVL41432; blocked evidence prevents all writes. Historical DO/journals remain unchanged.\n";
    exit;
}
$connection = null; $connected = false; $locked = false;
try {
    $environment = $options['environment'] ?? 'development';
    if (!in_array($environment,array('development','production'),true)) { throw new DomainException('Environment tidak valid.'); }
    $apply = isset($options['apply']);
    if ($apply && isset($options['basis'])) { throw new DomainException('Penerapan memakai basis dari preview.'); }
    if ($apply && isset($options['opening-file'])) { throw new DomainException('Penerapan memakai bukti dari preview; --opening-file hanya untuk preview baru.'); }
    if ($apply && (empty($options['preview-file']) || !is_string($options['actor'] ?? null) || !preg_match('/^[A-Za-z0-9_.@-]{1,50}$/D',$options['actor']))) { throw new DomainException('--apply memerlukan --preview-file dan --actor yang valid.'); }
    define('BASEPATH',dirname(__DIR__).'/system/'); define('ENVIRONMENT',$environment);
    $configFile = dirname(__DIR__).'/application/config/'.$environment.'/database.php';
    require is_file($configFile) ? $configFile : dirname(__DIR__).'/application/config/database.php';
    $config = $db['default'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_init(); $connection->options(MYSQLI_OPT_CONNECT_TIMEOUT,5); $connection->options(MYSQLI_OPT_READ_TIMEOUT,15);
    $connection->real_connect($config['hostname'],$config['username'],$config['password'],$config['database'],(int)($config['port'] ?? 3306));
    $connected = true;
    $connection->set_charset('utf8mb4');
    $store = new Stock_booking_store($connection,$options['actor'] ?? 'aquamatic-preview');
    $target = hash('sha256',$config['hostname'].':'.($config['port'] ?? 3306).'/'.$config['database']);
    if (!$apply) {
        $connection->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
        $opening = isset($options['opening-file']) ? json_decode(file_get_contents($options['opening-file']),true,512,JSON_THROW_ON_ERROR) : array();
        $report = aquamaticPreview($store,false,$opening,$options['basis'] ?? 'reconstructed'); $report['target']=$target;
        $connection->rollback();
    } else {
        $json = file_get_contents($options['preview-file']);
        if ($json === false) { throw new DomainException('File preview tidak dapat dibaca.'); }
        $approved = json_decode($json,true,512,JSON_THROW_ON_ERROR);
        if (($approved['target'] ?? '') !== $target) { throw new DomainException('Target database berbeda dari preview.'); }
        $approved['actor']=$options['actor'];
        $locked = (int)$store->query("SELECT GET_LOCK('waterco-stock-booking',15) acquired")[0]['acquired'] === 1;
        if (!$locked) { throw new DomainException('Stok sedang diproses; coba kembali.'); }
        $store->ready();
        if (!$connection->begin_transaction()) { throw new RuntimeException('Cannot start repair transaction'); }
        $report = aquamaticApply($store,$approved);
        if (!$connection->commit()) { throw new RuntimeException('Cannot commit repair transaction'); }
        $report['actor']=$options['actor']; $report['target']=$target;
    }
    echo json_encode($report,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR),PHP_EOL;
} catch (Throwable $error) {
    if ($connected) { $connection->rollback(); }
    fwrite(STDERR,$error->getMessage().PHP_EOL); exit(1);
} finally {
    if ($locked) { $store->query("SELECT RELEASE_LOCK('waterco-stock-booking')"); }
}
