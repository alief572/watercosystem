<?php
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';

class SpkDeliveryValidationStore extends Stock_booking_store
{
    public $planning = array(10 => array('qty_delivery' => 3, 'qty_spk' => 1), 11 => array('qty_delivery' => 1, 'qty_spk' => 0));
    public $usedSpk = false;
    public $quarantined = false;
    public $spkStatus = '0';

    public function __construct() {}
    public function ready() {}

    public function query($sql, $params = array())
    {
        if (strpos($sql, 'FROM stock_booking_quarantine') !== false) {
            return $this->quarantined ? array(array('id_stock' => 1)) : array();
        }
        if (strpos($sql, 'FROM tr_sales_order_detail') !== false) {
            return $params === array(1, 'SO1', 'PRODUCT1') ? array(array('id_so_detail' => 1)) : array();
        }
        if (strpos($sql, 'FROM tr_planning_delivery_detail') !== false) {
            return $params[1] == 1 && isset($this->planning[$params[0]]) ? array($this->planning[$params[0]]) : array();
        }
        if (strpos($sql, 'FROM tr_spk_delivery_detail') !== false) {
            return in_array($params[0], array(20, 21), true) ? array(array(
                'id_so_detail' => 1, 'no_so' => 'SO1', 'id_category3' => 'PRODUCT1',
                'qty_delivery' => 1, 'status_do' => $this->spkStatus,
            )) : array();
        }
        if (strpos($sql, 'FROM tr_delivery_order_detail') !== false) {
            return $this->usedSpk ? array(array('id_do_detail' => 1)) : array();
        }
        throw new RuntimeException('Unexpected query: ' . $sql);
    }
}

$checks = 0;
function checkSpkValidation($method, $rows, $expected = null, $configure = null)
{
    global $checks;
    $store = new SpkDeliveryValidationStore();
    if ($configure) { $configure($store); }
    try {
        $store->$method(array('dt' => $rows));
    } catch (DomainException $error) {
        if ($expected === null || $error->getMessage() !== $expected) { throw $error; }
        ++$checks;
        return;
    }
    if ($expected !== null) { throw new RuntimeException('Expected rejection: ' . $expected); }
    ++$checks;
}

$row = array('kirim' => 'on', 'id_so' => 1, 'no_so' => 'SO1', 'id_category3' => 'PRODUCT1',
    'id_planning_delivery' => 10, 'qty_delivery' => 1, 'id_spk' => 20);
checkSpkValidation('validateSpk', array($row, $row));
checkSpkValidation('validateSpk', array($row, $row, $row), 'SPK melebihi Qty planning.');
checkSpkValidation('validateSpk', array(array_replace($row, array('qty_delivery' => 2))));
checkSpkValidation('validateSpk', array(array_replace($row, array('qty_delivery' => 3))), 'SPK melebihi Qty planning.');
checkSpkValidation('validateSpk', array($row, array_replace($row, array('id_planning_delivery' => 11))));
checkSpkValidation('validateSpk', array($row, array_replace($row, array('kirim' => ''))));
checkSpkValidation('validateSpk', array(), 'Detail SPK kosong.');
checkSpkValidation('validateSpk', array(array_replace($row, array('kirim' => ''))), 'Tidak ada barang dipilih untuk SPK.');
checkSpkValidation('validateSpk', array(array_replace($row, array('qty_delivery' => 0))), 'Referensi/Qty SPK tidak valid.');
checkSpkValidation('validateSpk', array(array_replace($row, array('qty_delivery' => '1.5'))), 'Qty stok harus bilangan bulat yang valid dan tidak negatif.');
checkSpkValidation('validateSpk', array(array_replace($row, array('id_category3' => 'OTHER'))), 'Referensi/Qty SPK tidak valid.');
checkSpkValidation('validateSpk', array(array_replace($row, array('id_planning_delivery' => 99))), 'SPK melebihi Qty planning.');
checkSpkValidation('validateSpk', array($row), 'Detail SO memuat barang yang sedang dikarantina.', function ($s) { $s->quarantined = true; });
checkSpkValidation('validateDeliveryDraft', array($row, array_replace($row, array('id_spk' => 21))));
checkSpkValidation('validateDeliveryDraft', array($row, $row), 'Detail SPK pada DO duplikat.');
checkSpkValidation('validateDeliveryDraft', array(array_replace($row, array('qty_delivery' => 2))), 'Barang/Qty DO tidak sesuai detail SPK.');
checkSpkValidation('validateDeliveryDraft', array($row), 'Detail SPK sudah digunakan pada DO.', function ($s) { $s->usedSpk = true; });
checkSpkValidation('validateDeliveryDraft', array($row), 'Detail SPK sudah dibuatkan DO atau tidak ditemukan.', function ($s) { $s->spkStatus = '1'; });
echo "PASS: $checks SPK/DO validation cases\n";
