<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Daftar DataTable serverside (POST draw/start/length/search/order).
 *
 * $cfg: from (tabel + join), select, where (kondisi tetap, tanpa "WHERE"), binds (nilai kondisi tetap),
 *       search (kolom yang dicari), sort (index kolom DataTable => ekspresi SQL), default (urutan bawaan).
 * Lempar DomainException bila parameter tidak valid; semua nilai di-bind, LIMIT maksimal 100.
 */
function dt_list($db, array $request, array $cfg)
{
    $page = array();
    foreach (array('draw' => 0, 'start' => 0, 'length' => 10) as $key => $default) {
        $page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
        if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
            throw new DomainException('Parameter ' . $key . ' tidak valid.');
        }
    }
    $page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);

    $search = $request['search'] ?? array();
    if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
    $search = $search['value'] ?? '';
    $size = is_string($search) ? preg_match_all('/./us', $search) : false;
    if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');

    $orders = $request['order'] ?? array();
    if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
    $sort = array();
    foreach (array_slice($orders, 0, 6) as $order) {
        if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
        $column = filter_var($order['column'] ?? '', FILTER_VALIDATE_INT);
        if (!isset($cfg['sort'][$column])) continue;
        if (!in_array($order['dir'] ?? '', array('asc', 'desc'), true)) throw new DomainException('Arah urutan tidak valid.');
        $sort[] = $cfg['sort'][$column] . ' ' . strtoupper($order['dir']);
    }
    if (!$sort) $sort[] = $cfg['default'];
    // Pembeda akhir (mis. PK) agar urutan dan paging stabil saat nilai kolom urut sama.
    if (!empty($cfg['tiebreak'])) $sort[] = $cfg['tiebreak'];

    $where = $cfg['where'] ?? '1 = 1';
    $binds = $cfg['binds'] ?? array();
    $total = dt_query($db, 'SELECT COUNT(*) AS n FROM ' . $cfg['from'] . ' WHERE ' . $where, $binds)->row()->n;

    $filtered = $total;
    if ($search !== '') {
        $needle = '%' . str_replace(array('!', '%', '_'), array('!!', '!%', '!_'), $search) . '%';
        $parts = array();
        foreach ($cfg['search'] as $field) {
            $parts[] = $field . " LIKE ? ESCAPE '!'";
            $binds[] = $needle;
        }
        $where .= ' AND (' . implode(' OR ', $parts) . ')';
        $filtered = dt_query($db, 'SELECT COUNT(*) AS n FROM ' . $cfg['from'] . ' WHERE ' . $where, $binds)->row()->n;
    }

    $rows = dt_query($db, 'SELECT ' . $cfg['select'] . ' FROM ' . $cfg['from'] . ' WHERE ' . $where
        . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], $binds)->result();

    return array('draw' => $page['draw'], 'start' => $page['start'], 'total' => (int) $total, 'filtered' => (int) $filtered, 'rows' => $rows);
}

/** Pola LIKE '%nilai%' dengan karakter khusus di-escape (dipakai bersama ESCAPE '!'). */
function dt_like($value)
{
    return '%' . str_replace(array('!', '%', '_'), array('!!', '!%', '!_'), (string) $value) . '%';
}

function dt_query($db, $sql, array $binds = array())
{
    $query = $db->query($sql, $binds);
    if (!$query) throw new RuntimeException('Cannot read list data');
    return $query;
}

/**
 * Bungkus endpoint JSON DataTable: db_debug dimatikan sementara, error jadi JSON (bukan halaman HTML/500).
 * $build: fungsi yang mengembalikan array JSON DataTable.
 */
function dt_respond($ci, callable $build, $label)
{
    $debug = $ci->db->db_debug;
    $ci->db->db_debug = false;
    $draw = filter_var($ci->input->post('draw'), FILTER_VALIDATE_INT);
    $reply = array('draw' => $draw !== false && $draw >= 0 ? $draw : 0, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => array());
    try {
        $reply = $build();
    } catch (Throwable $e) {
        log_message('error', $label . ': ' . $e->getMessage());
        $reply['error'] = $e instanceof DomainException ? $e->getMessage() : 'Gagal memuat data.';
    } finally {
        $ci->db->db_debug = $debug;
    }
    $ci->output->set_content_type('application/json');
    echo json_encode($reply);
}
