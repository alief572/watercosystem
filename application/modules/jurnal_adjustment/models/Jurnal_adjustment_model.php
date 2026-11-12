<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_adjustment_model extends BF_Model
{
    private function query($sql, $params = array())
    {
        try { $result = $this->db->query($sql, $params); }
        catch (mysqli_sql_exception $error) {
            if (in_array($error->getCode(), array(1062, 1205, 1213), true)) {
                throw new DomainException('Nomor jurnal bentrok atau transaksi sedang diproses. Periksa status lalu coba kembali.', 409, $error);
            }
            throw $error;
        }
        if ($result === false) {
            $error = $this->db->error();
            if (in_array((int)$error['code'], array(1062, 1205, 1213), true)) {
                throw new DomainException('Nomor jurnal bentrok atau transaksi sedang diproses. Periksa status lalu coba kembali.', 409);
            }
            throw new RuntimeException('Database error '.$error['code'].': '.$error['message']);
        }
        return $result;
    }

    public function get_data_adjustment($datatable = null, $id = null)
    {
        if ($datatable === null) {
            $this->validate_id($id);
            $rows = $this->query('SELECT * FROM '.DBERP.'.adjustment_stock WHERE id_transaksi=?', array($id))->result();
            if (count($rows) !== 1) { throw new DomainException(count($rows) ? 'ID adjustment ganda. Perlu rekonsiliasi.' : 'Adjustment tidak ditemukan.', count($rows) ? 409 : 404); }
            return $rows[0];
        }
        $where = "adjustment IN ('PLUS','MINUS') AND (status_jurnal='OPN' OR status_jurnal IS NULL)";
        $total = (int)$this->query('SELECT COUNT(*) total FROM '.DBERP.'.adjustment_stock WHERE '.$where)->row()->total;
        $params = array();
        $search = $datatable['search'] ?? '';
        if (is_string($search) && $search !== '') {
            $parts = array();
            foreach (array('id_transaksi', "DATE_FORMAT(tanggal_transaksi,'%d %M %Y')", 'nama_material', 'adjustment', 'nama_gudang', 'note', 'total_qty') as $field) {
                $parts[] = $field." LIKE ? ESCAPE '!'";
                $params[] = '%'.$this->db->escape_like_str(substr($search, 0, 255)).'%';
            }
            $where .= ' AND ('.implode(' OR ', $parts).')';
        }
        $filtered = (int)$this->query('SELECT COUNT(*) total FROM '.DBERP.'.adjustment_stock WHERE '.$where, $params)->row()->total;
        $start = max(0, (int)($datatable['start'] ?? 0));
        $length = (int)($datatable['length'] ?? 10);
        $limit = $length === -1 ? '' : ' LIMIT '.max(1, min(100, $length)).' OFFSET '.$start;
        return array('count_all'=>$total, 'count_filter'=>$filtered,
            'data'=>$this->query('SELECT * FROM '.DBERP.'.adjustment_stock WHERE '.$where.' ORDER BY tanggal_transaksi DESC,id_transaksi DESC'.$limit, $params)->result());
    }

    private function validate_id($id)
    {
        if (!is_string($id) || trim($id) === '' || strlen($id) > 25 || !preg_match('//u', $id) || preg_match('/[\x00-\x1f\x7f]/', $id)) {
            throw new DomainException('ID adjustment tidak valid (maksimal 25 byte).', 422);
        }
    }

    public function assert_transactional_tables()
    {
        foreach (array(DBERP.'.adjustment_stock', DBACC.'.javh', DBACC.'.jurnal', DBACC.'.pastibisa_tb_cabang') as $table) {
            $definition = $this->query('SHOW CREATE TABLE '.$table)->row_array();
            if (!isset($definition['Create Table']) || !preg_match('/\bENGINE=InnoDB\b/i', $definition['Create Table'])) {
                throw new DomainException('Posting dinonaktifkan sampai migrasi tabel InnoDB selesai diverifikasi.', 503);
            }
        }
    }

    public function get_costbook($material, $date, $lock = false)
    {
        $current = $date === date('Y-m-d');
        $table = $current ? 'ms_costbook' : 'ms_costbook_backup';
        $sql = 'SELECT * FROM '.DBERP.'.'.$table.' WHERE id_category3=?';
        $params = array($material);
        if (!$current) {
            $sql .= ' AND tgl>=? AND tgl<?';
            $params[] = $date.' 00:00:00';
            $params[] = date('Y-m-d', strtotime($date.' +1 day')).' 00:00:00';
        }
        $sql .= $current ? ' ORDER BY id DESC LIMIT 2' : ' ORDER BY tgl DESC,id DESC LIMIT 2';
        $rows = $this->query($sql.($lock ? ' FOR UPDATE' : ''), $params)->result();
        if (!$rows || (count($rows) > 1 && ($current || $rows[0]->tgl === $rows[1]->tgl))) {
            throw new DomainException('Costbook tanggal adjustment tidak tersedia atau ambigu. Lengkapi costbook lalu buka preview ulang.', 422);
        }
        $row = $rows[0];
        if (!is_numeric($row->nilai_costbook) || !is_finite((float)$row->nilai_costbook) || (float)$row->nilai_costbook <= 0) {
            throw new DomainException('Costbook harus berupa nilai positif yang valid.', 422);
        }
        $row->source = $table;
        $row->source_date = $current ? $date : $row->tgl;
        return $row;
    }

    public function prepare_journal($id, $lock = false)
    {
        $this->validate_id($id);
        $postingDate = date('Y-m-d');
        $rows = $this->query('SELECT * FROM '.DBERP.'.adjustment_stock WHERE id_transaksi=?'.($lock ? ' FOR UPDATE' : ''), array($id))->result();
        if (count($rows) !== 1) { throw new DomainException(count($rows) ? 'ID adjustment ganda. Perlu rekonsiliasi.' : 'Adjustment tidak ditemukan.', count($rows) ? 409 : 404); }
        $adjustment = $rows[0];
        if ($adjustment->status_jurnal === 'CLS') { throw new DomainException('Adjustment sudah diposting. Tidak boleh diposting ulang.', 409); }
        if (!in_array($adjustment->status_jurnal, array(null, 'OPN'), true) || !in_array($adjustment->adjustment, array('PLUS','MINUS'), true)) {
            throw new DomainException('Hanya adjustment PLUS/MINUS terbuka yang dapat diposting. MUTASI tidak dibuatkan jurnal.', 422);
        }
        $date = $adjustment->tanggal_transaksi;
        $parsed = is_string($date) ? DateTimeImmutable::createFromFormat('!Y-m-d', $date) : false;
        if (!$parsed || $parsed->format('Y-m-d') !== $date || $date > $postingDate) { throw new DomainException('Tanggal adjustment tidak valid atau masih di masa depan.', 422); }
        if (!preg_match('/^[1-9][0-9]*$/D', (string)$adjustment->total_qty) || (float)$adjustment->total_qty > 2147483647 || trim((string)$adjustment->id_material) === '') {
            throw new DomainException('Material dan qty adjustment harus valid; qty berupa bilangan bulat positif.', 422);
        }
        $branches = $this->query('SELECT id,nocab,subcab,nomorJC FROM '.DBACC.'.pastibisa_tb_cabang WHERE nocab=?'.($lock ? ' FOR UPDATE' : ''), array('101'))->result();
        if (count($branches) !== 1 || !preg_match('/^[A-Z0-9]$/D', $branches[0]->subcab)) { throw new DomainException('Konfigurasi cabang 101 tidak lengkap atau ganda.', 422); }
        $branch = $branches[0];
        $costbook = $this->get_costbook($adjustment->id_material, $date, $lock);
        $amount = round((float)$adjustment->total_qty * (float)$costbook->nilai_costbook);
        // ponytail: DOUBLE schema keeps whole-unit amounts; use DECIMAL before allowing fractional postings.
        if (!is_finite($amount) || $amount < 1 || $amount > 9007199254740991) { throw new DomainException('Nilai jurnal di luar batas nominal yang dapat diposting.', 422); }
        $accounts = $this->query('SELECT no_perkiraan,nama FROM '.DBACC.'.coa_master WHERE kdcab=? AND no_perkiraan IN (?,?) ORDER BY no_perkiraan', array('101-'.$branch->subcab, '1105-01-01', '6201-01-51'))->result();
        if (count($accounts) !== 2 || $accounts[0]->no_perkiraan !== '1105-01-01' || $accounts[1]->no_perkiraan !== '6201-01-51') {
            throw new DomainException('COA persediaan dan selisih harus lengkap dan masing-masing satu untuk cabang accounting.', 422);
        }
        $description = 'Adjustment '.$adjustment->adjustment.' '.$id;
        $old = $this->query('SELECT nomor FROM '.DBACC.'.jurnal WHERE no_reff=? LIMIT 1', array($id))->row();
        $oldHeader = $this->query('SELECT nomor FROM '.DBACC.'.javh WHERE keterangan IN (?,?,?) LIMIT 1', array('Adjustment PLUS '.$id, 'Adjustment MINUS '.$id, 'Adjustment MUTASI '.$id))->row();
        if ($old || $oldHeader) { throw new DomainException('Referensi adjustment sudah memiliki jurnal. Perlu rekonsiliasi sebelum posting.', 409); }
        $lines = array();
        foreach ($accounts as $account) {
            $debit = ($account->no_perkiraan === '1105-01-01') === ($adjustment->adjustment === 'PLUS');
            $lines[] = array('tanggal'=>$postingDate, 'tipe'=>$adjustment->adjustment, 'no_coa'=>$account->no_perkiraan,
                'keterangan'=>$account->nama, 'no_reff'=>$id, 'debit'=>$debit ? $amount : 0, 'kredit'=>$debit ? 0 : $amount);
        }
        $snapshot = array('id'=>$id, 'material'=>$adjustment->id_material, 'type'=>$adjustment->adjustment, 'qty'=>(int)$adjustment->total_qty,
            'adjustment_date'=>$date, 'posting_date'=>$postingDate, 'source'=>$costbook->source, 'costbook_id'=>$costbook->id,
            'source_date'=>$costbook->source_date, 'costbook'=>(float)$costbook->nilai_costbook, 'amount'=>$amount,
            'branch_id'=>$branch->id, 'branch'=>'101-'.$branch->subcab, 'lines'=>$lines);
        return array('data_adjustment'=>$adjustment, 'data_jurnal'=>$lines, 'costbook'=>$costbook, 'amount'=>$amount,
            'branch'=>$branch, 'description'=>$description, 'snapshot'=>$snapshot);
    }

    public function post_journal($id, $snapshot, $user)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $started = false;
        try {
            if ((!is_string($user) && !is_int($user)) || trim((string)$user) === '' || strlen((string)$user) > 20) { throw new DomainException('Identitas pengguna posting tidak valid.', 422); }
            $this->assert_transactional_tables();
            if (!$this->db->trans_begin()) { throw new RuntimeException('Cannot begin journal transaction'); }
            $started = true;
            $prepared = $this->prepare_journal($id, true);
            if ($snapshot !== $prepared['snapshot']) { throw new DomainException('Data adjustment, costbook, akun, atau tanggal posting berubah. Buka preview ulang.', 409); }
            $branch = $prepared['branch'];
            if (!preg_match('/^[0-9]+$/D', (string)$branch->nomorJC) || (float)$branch->nomorJC >= 2147483647) { throw new DomainException('Counter jurnal cabang tidak valid atau sudah mencapai batas.', 422); }
            $next = (int)$branch->nomorJC + 1;
            $postingDate = $prepared['snapshot']['posting_date'];
            $number = '101-'.$branch->subcab.'JV'.substr($postingDate, 2, 2).str_pad($next, 5, '0', STR_PAD_LEFT);
            if (strlen($number) > 20) { throw new DomainException('Nomor jurnal melewati kapasitas header.', 422); }
            if ($this->query('SELECT nomor FROM '.DBACC.'.jurnal WHERE nomor=? LIMIT 1', array($number))->row()) {
                throw new DomainException('Nomor jurnal sudah digunakan. Periksa counter dan jurnal lama sebelum mencoba kembali.', 409);
            }
            $this->query('UPDATE '.DBACC.'.pastibisa_tb_cabang SET nomorJC=? WHERE id=? AND nomorJC=?', array($next, $branch->id, $branch->nomorJC));
            if ($this->db->affected_rows() !== 1) { throw new RuntimeException('Journal counter update affected unexpected rows'); }
            $header = array('nomor'=>$number, 'tgl'=>$postingDate, 'jml'=>$prepared['amount'], 'koreksi_no'=>'-', 'kdcab'=>'101',
                'jenis'=>'JV', 'keterangan'=>$prepared['description'], 'bulan'=>substr($postingDate,5,2), 'tahun'=>substr($postingDate,0,4), 'user_id'=>$user,
                'memo'=>'', 'tgl_jvkoreksi'=>$postingDate, 'ho_valid'=>'');
            $this->insert_journal_row(DBACC.'.javh', $header);
            foreach ($prepared['data_jurnal'] as $line) {
                $this->insert_journal_row(DBACC.'.jurnal', array('tipe'=>'JV', 'nomor'=>$number, 'tanggal'=>$line['tanggal'], 'no_perkiraan'=>$line['no_coa'],
                    'keterangan'=>$prepared['description'], 'jenis_trans'=>'', 'no_reff'=>$id, 'stspos'=>'0', 'debet'=>$line['debit'], 'kredit'=>$line['kredit']));
            }
            $this->query("UPDATE ".DBERP.".adjustment_stock SET status_jurnal='CLS',costbook=?,total_value=? WHERE id_transaksi=? AND (status_jurnal='OPN' OR status_jurnal IS NULL)", array($prepared['costbook']->nilai_costbook, $prepared['amount'], $id));
            if ($this->db->affected_rows() !== 1) { throw new RuntimeException('Adjustment update affected unexpected rows'); }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) { throw new RuntimeException('Journal commit not confirmed; inspect adjustment status before retry'); }
            $started = false;
            return $number;
        } finally {
            try { if ($started && !$this->db->trans_rollback()) { log_message('error', 'Journal adjustment rollback was not confirmed'); } }
            finally { $this->db->db_debug = $debug; }
        }
    }

    private function insert_journal_row($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $this->query('INSERT INTO '.$table.' ('.$columns.') VALUES ('.implode(',', array_fill(0, count($data), '?')).')', array_values($data));
        if ($this->db->affected_rows() !== 1) { throw new RuntimeException('Journal insert affected unexpected rows'); }
    }
}
