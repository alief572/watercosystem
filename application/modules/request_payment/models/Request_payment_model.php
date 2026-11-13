<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request_payment_model extends BF_Model
{
    protected $table_name = 'request_payment';
    protected $key = 'id';

    public function query($sql, $binds = []) {
        $query = $this->db->query($sql, $binds);
        if (!$query) throw new RuntimeException('Payment database operation failed');
        return $query;
    }

    public function text($value, $label, $max, $required = true) {
        if (!is_scalar($value) || is_bool($value)) throw new DomainException($label . ' tidak valid.');
        $value = trim((string)$value); $size = preg_match_all('/./us', $value);
        if ($size === false || $size > $max || ($required && $value === '')) throw new DomainException($label . ' tidak valid.');
        return $value;
    }

    public function id($value) {
        $value = $this->text($value,'ID',20);
        if (!ctype_digit($value) || !preg_match('/[1-9]/',$value)) throw new DomainException('ID tidak valid.');
        return $value;
    }

    public function date($value) {
        $value = $this->text($value,'Tanggal',10);
        $date = DateTimeImmutable::createFromFormat('!Y-m-d',$value);
        if (!$date || $date->format('Y-m-d') !== $value || (int)$date->format('Y') < 1000) throw new DomainException('Tanggal tidak valid.');
        return $value;
    }

    public function money($value, $signed = false) {
        $value = $this->text($value,'Nominal',100);
        if (!preg_match('/^' . ($signed ? '-?' : '') . '(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]{1,2})?$/D',$value)) throw new DomainException('Nominal tidak valid.');
        $value = str_replace(',','',$value); $negative = $value[0] === '-'; $parts = explode('.',ltrim($value,'-'));
        if (strlen(ltrim($parts[0],'0')) > 13) throw new DomainException('Nominal melewati batas aman.');
        // ponytail: cents stay exact within 2^53-1; larger amounts require decimal DB arithmetic.
        $cents = (int)$parts[0] * 100 + (int)str_pad($parts[1] ?? '',2,'0');
        if ($cents > 9007199254740991) throw new DomainException('Nominal melewati batas aman.');
        return $negative ? -$cents : $cents;
    }

    public function amount($cents) {
        if (!is_int($cents) || abs($cents) > 9007199254740991) throw new DomainException('Total melewati batas aman.');
        $absolute = abs($cents);
        return ($cents < 0 ? '-' : '').intdiv($absolute,100).'.'.str_pad((string)($absolute % 100),2,'0',STR_PAD_LEFT);
    }
    public function version($rows) { return hash('sha256',serialize($rows)); }

    public function legacyAmount($cents) {
        // ponytail: nilai_request is DOUBLE(11,0); use jumlah for cents until the column is migrated.
        $rounded = (int)round($cents / 100);
        if (abs($rounded) > 99999999999) throw new DomainException('Nominal melebihi kapasitas kolom nilai_request.');
        return $rounded;
    }

    public function type($value) {
        if (!in_array($value,['expense','kasbon','transportasi','nonpo','periodik'],true)) throw new DomainException('Tipe dokumen tidak valid.');
        return $value;
    }

    public function sourcesSql() {
        return "SELECT a.id AS ids,a.no_doc,a.nama,a.tgl_doc,'Transportasi' AS keperluan,'transportasi' AS tipe,a.jumlah_expense AS jumlah,a.bank_id,a.accnumber,a.accname FROM tr_transport_req a WHERE a.status=1
            UNION ALL SELECT a.id,a.no_doc,a.nama,a.tgl_doc,a.keperluan,'kasbon',a.jumlah_kasbon,a.bank_id,a.accnumber,a.accname FROM tr_kasbon a WHERE a.status=1
            UNION ALL SELECT a.id,a.no_doc,a.nama,a.tgl_doc,a.informasi,'expense',a.jumlah,a.bank_id,a.accnumber,a.accname FROM tr_expense a WHERE a.status=1
            UNION ALL SELECT a.id,a.no_doc,a.pic,a.tanggal_doc,a.info,'nonpo',a.nilai_request,a.bank_id,a.accnumber,a.accname FROM tr_non_po_header a WHERE a.status=3
            UNION ALL SELECT b.id,a.no_doc,COALESCE((SELECT MIN(u.nama_karyawan) FROM user_emp u WHERE u.username=a.created_by OR CAST(u.id AS CHAR)=a.created_by),a.created_by),a.tanggal_doc,b.nama,'periodik',b.nilai,b.bank_id,b.accnumber,b.accname
            FROM tr_pengajuan_rutin a JOIN tr_pengajuan_rutin_detail b ON b.no_doc=a.no_doc WHERE a.status=1 AND COALESCE(b.id_payment,0)=0 AND b.status='0'";
    }


    public function requestVersion($row) {
        $values = [];
        foreach (['ids','no_doc','nama','tgl_doc','keperluan','tipe','jumlah','bank_id','accnumber','accname'] as $field) $values[$field] = $field === 'jumlah' ? $this->amount($this->money($row[$field],true)) : (string)($row[$field] ?? '');
        return $this->version($values);
    }

    public function source($type, $id, $lock = false) {
        $type = $this->type($type); $id = $this->id($id); $end = $lock ? ' FOR UPDATE' : '';
        $tables = ['expense'=>'tr_expense','kasbon'=>'tr_kasbon','transportasi'=>'tr_transport_req','nonpo'=>'tr_non_po_header','periodik'=>'tr_pengajuan_rutin_detail'];
        $header = $this->query('SELECT * FROM '.$tables[$type].' WHERE id=?'.$end,[$id])->row_array();
        if (!$header) throw new DomainException('Dokumen sumber tidak ditemukan.');
        $this->text($header['no_doc'],'Nomor dokumen',50);
        $same = $this->query('SELECT id FROM '.$tables[$type].' WHERE no_doc=?'.$end,[$header['no_doc']])->result_array();
        if ($type !== 'periodik' && count($same) !== 1) throw new DomainException('Nomor sumber ambigu.');
        $parent = null;
        if ($type === 'periodik') {
            $parents = $this->query('SELECT * FROM tr_pengajuan_rutin WHERE no_doc=?'.$end,[$header['no_doc']])->result_array();
            if (count($parents) !== 1) throw new DomainException('Header rutin tidak ditemukan atau ambigu.');
            $parent = $parents[0]; $details = [$header];
        } elseif ($type === 'kasbon') $details = [$header];
        else {
            $detailTable = ['expense'=>'tr_expense_detail','transportasi'=>'tr_transport','nonpo'=>'tr_non_po_detail'][$type];
            $field = $type === 'transportasi' ? 'no_req' : 'no_doc';
            $details = $this->query('SELECT * FROM '.$detailTable.' WHERE '.$field.'=? ORDER BY id'.$end,[$header['no_doc']])->result_array();
        }
        $request = $this->query('SELECT * FROM request_payment WHERE tipe=? AND ids=? ORDER BY id'.$end,[$type,$id])->result_array();
        if (count($request) > 1) throw new DomainException('Request ganda. Perlu rekonsiliasi.');
        return ['type'=>$type,'header'=>$header,'parent'=>$parent,'details'=>$details,'request'=>$request[0] ?? null,
            'version'=>$this->version([$header,$parent,$details,$request])];
    }

    public function requestable($source) {
        $type = $source['type']; $h = $source['header'];
        if ($source['request']) throw new DomainException('Dokumen sudah diajukan.');
        if (!$source['details']) throw new DomainException('Sumber tidak mempunyai detail.');
        if ($type === 'periodik') {
            if ((string)$source['parent']['status'] !== '1' || (int)$h['id_payment'] !== 0 || (string)$h['status'] !== '0') throw new DomainException('Detail rutin sudah diproses.');
        } elseif ((string)$h['status'] !== ($type === 'nonpo' ? '3' : '1')) throw new DomainException('Sumber belum disetujui atau sudah diproses.');
        if ($this->query('SELECT id FROM payment_approve WHERE tipe=? AND ids=? LIMIT 1',[$type,$h['id']])->row()) throw new DomainException('Sumber sudah mempunyai pembayaran.');
    }

    public function pending($source) {
        $r = $source['request']; $type = $source['type']; $h = $source['header'];
        if (!$r || !in_array((string)$r['status'],['0','1'],true) || $r['no_doc'] !== $h['no_doc']) throw new DomainException('Request sudah selesai atau relasi tidak valid.');
        if ($type === 'periodik') {
            if ((string)$source['parent']['status'] !== '1' || (string)$h['id_payment'] !== (string)$r['id']) throw new DomainException('Relasi rutin tidak valid.');
        } elseif ((string)$h['status'] !== ['expense'=>'2','kasbon'=>'2','transportasi'=>'2','nonpo'=>'4'][$type]) throw new DomainException('Status sumber berubah.');
    }

    public function eligible($type, $row) { return (string)$row['status'] === ['expense'=>'0','kasbon'=>'2','transportasi'=>'1','nonpo'=>'0','periodik'=>'0'][$type]; }

    public function restricted($source) {
        if ($source['type'] !== 'expense') return false;
        $h = $source['header'];
        if ($this->money($h['add_ppn_nilai'] ?? 0) || $this->money($h['add_pph_nilai'] ?? 0)) return true;
        foreach ($source['details'] as $row) if ($row['id_kasbon'] !== null && $row['id_kasbon'] !== '') return true;
        return false;
    }

    public function snapshot($type, $row) {
        $map = ['expense'=>['tanggal','deskripsi','qty','harga','total_harga','keterangan'],
            'kasbon'=>['tgl_doc','keperluan',null,'jumlah_kasbon','jumlah_kasbon','keperluan'],
            'transportasi'=>['tgl_doc','keperluan',null,'jumlah_kasbon','jumlah_kasbon','keperluan'],
            'nonpo'=>['tgl_pr','deskripsi',null,'nilai_satuan_request','total_request','keterangan'],
            'periodik'=>['tanggal','nama',null,'nilai','nilai','keterangan']][$type];
        [$date,$description,$qty,$price,$total,$note] = $map;
        $quantity = $qty ? $this->id($row[$qty]) : '1';
        if ((float)$quantity > 2147483647) throw new DomainException('Qty melebihi kapasitas snapshot.');
        return ['no_doc'=>$this->text($type === 'transportasi' ? $row['no_req'] : $row['no_doc'],'Nomor dokumen',50),
            'tgl_doc'=>$this->date($row[$date]),'deskripsi'=>$this->text($row[$description],'Deskripsi',255),
            'qty'=>$quantity,'harga'=>$this->amount($this->money($row[$price])),'total'=>$this->amount($this->money($row[$total])),
            'keterangan'=>$this->text($row[$note] ?? '','Keterangan detail',255,false),'doc_file'=>$this->text($row['doc_file'] ?? '','Lampiran',100,false),
            'coa'=>$this->text($row['coa'] ?? '','COA',15,false)];
    }

    public function write($method, $table, $data, $where = null) {
        if ($where !== null) $this->db->where($where);
        if (!$this->db->$method($table,$data)) throw new RuntimeException('Cannot '.$method.' '.$table.': '.$this->db->error()['message']);
    }

    public function payment($id, $lock = false) {
        $id = $this->text($id,'ID pembayaran',15);
        if (!preg_match('/^PAY[0-9]{9}$/D',$id)) throw new DomainException('ID pembayaran tidak valid.');
        $end = $lock ? ' FOR UPDATE' : '';
        $h = $this->query('SELECT * FROM payment_approve WHERE id=?'.$end,[$id])->row_array();
        if (!$h || (string)$h['status'] !== '1') throw new DomainException('Pembayaran sudah diproses atau tidak ditemukan.');
        $d = $this->query('SELECT * FROM payment_approve_details WHERE payment_id=? ORDER BY id'.$end,[$id])->result_array();
        if (!$d) throw new DomainException('Snapshot pembayaran kosong. Perlu rekonsiliasi.');
        return ['header'=>$h,'details'=>$d,'version'=>$this->version([$h,$d])];
    }

    public function journalSql() {
        return "SELECT nomor,MIN(tanggal) AS tanggal,MIN(no_reff) AS no_reff,MIN(keterangan) AS keterangan,
            SUM(kredit) AS total,MAX(COALESCE(stspos,'0')) AS stspos FROM jurnal WHERE jenis_jurnal='BUK030' GROUP BY nomor";
    }

    public function journal($number) {
        $number = $this->text($number,'Nomor jurnal',25);
        $rows = $this->query("SELECT * FROM jurnal WHERE nomor=? AND jenis_jurnal='BUK030' ORDER BY id",[$number])->result_array();
        if (!$rows) throw new DomainException('Jurnal tidak ditemukan.');
        return ['rows'=>$rows,'version'=>$this->version($rows)];
    }

    public function journalGroups($rows) {
        $groups = [];
        foreach ($rows as $r) {
            $coa = $r['no_perkiraan'];
            if (!isset($groups[$coa])) $groups[$coa] = ['id'=>(string)$r['id'],'coa'=>$coa,'keterangan'=>$r['keterangan'],'debet'=>0,'kredit'=>0];
            $groups[$coa]['debet'] += $this->money($r['debet']); $groups[$coa]['kredit'] += $this->money($r['kredit']);
        }
        return array_values($groups);
    }

    public function listData($kind, $request, $export = false) {
        $maps = ['request'=>['no_doc','nama','tgl_doc','keperluan','tipe','jumlah'],
            'approval'=>['no_doc','nama','tgl_doc','keperluan','tipe','jumlah','jumlah','tanggal','status'],
            'payment'=>['no_doc','nama','tgl_doc','keperluan','tipe','jumlah','tanggal'],
            'jurnal'=>['no_reff','nomor','tanggal','keterangan','total','stspos']];
        $sources = ['request'=>$this->sourcesSql(),'approval'=>'SELECT * FROM request_payment WHERE status IN (0,1)',
            'payment'=>'SELECT * FROM payment_approve WHERE status=1','jurnal'=>$this->journalSql()];
        if (!isset($maps[$kind]) || !is_array($request)) throw new DomainException('Daftar tidak valid.');
        $page = [];
        foreach (['draw'=>0,'start'=>0,'length'=>10] as $key=>$default) {
            $page[$key] = filter_var($request[$key] ?? $default,FILTER_VALIDATE_INT);
            if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) throw new DomainException('Pagination tidak valid.');
        }
        $page['length'] = $page['length'] === -1 ? 100 : min(100,$page['length']);
        $search = $request['search'] ?? [];
        if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
        $needle = $this->text($search['value'] ?? '','Pencarian',255,false);
        $from = ' FROM ('.$sources[$kind].') a'; $where = ''; $binds = [];
        if ($kind === 'payment' && isset($request['_payment_ids'])) {
            $ids = $request['_payment_ids'];
            $where = $ids ? ' WHERE a.id IN ('.implode(',',array_fill(0,count($ids),'?')).')' : ' WHERE 1=0';
            $binds = $ids;
        }
        if ($needle !== '') {
            $parts = [];
            $fields = array_map(function ($field) { return 'a.'.$field; },$maps[$kind]);
            if ($kind === 'approval') $fields[] = "CASE a.status WHEN 0 THEN 'Open' WHEN 1 THEN 'Partial Payment' WHEN 2 THEN 'Full Payment' ELSE 'Undefined' END";
            foreach ($fields as $field) { $parts[] = $field." LIKE ? ESCAPE '!'"; $binds[] = '%'.str_replace(['!','%','_'],['!!','!%','!_'],$needle).'%'; }
            $where .= ($where ? ' AND (' : ' WHERE (').implode(' OR ',$parts).')';
        }
        $orders = $request['order'] ?? []; if (!is_array($orders)) throw new DomainException('Urutan tidak valid.');
        $sort = [];
        foreach (array_slice($orders,0,6) as $order) {
            if (!is_array($order)) throw new DomainException('Urutan tidak valid.');
            $column = filter_var($order['column'] ?? '',FILTER_VALIDATE_INT);
            if ($column === false || !isset($maps[$kind][$column-1])) continue;
            if (!in_array($order['dir'] ?? '',['asc','desc'],true)) throw new DomainException('Arah urutan tidak valid.');
            $sort[] = 'a.'.$maps[$kind][$column-1].' '.strtoupper($order['dir']);
        }
        if (!$sort && $kind === 'approval') $sort = ['a.tanggal DESC','a.tipe ASC'];
        $sort[] = $kind === 'request' ? 'a.tipe ASC,a.ids DESC' : ($kind === 'jurnal' ? 'a.nomor DESC' : 'a.id DESC');
        $baseWhere = $kind === 'payment' && isset($request['_payment_ids']) ? ($request['_payment_ids'] ? ' WHERE a.id IN ('.implode(',',array_fill(0,count($request['_payment_ids']),'?')).')' : ' WHERE 1=0') : '';
        $total = (int)$this->query('SELECT COUNT(*) AS n'.$from.$baseWhere,$baseWhere ? $request['_payment_ids'] : [])->row()->n;
        $filtered = $where ? (int)$this->query('SELECT COUNT(*) AS n'.$from.$where,$binds)->row()->n : $total;
        $sql = 'SELECT a.*'.$from.$where.' ORDER BY '.implode(',',$sort);
        if (!$export) $sql .= ' LIMIT '.$page['length'].' OFFSET '.$page['start'];
        return $page + ['total'=>$total,'filtered'=>$filtered,'rows'=>$this->query($sql,$binds)->result_array()];
    }
}
