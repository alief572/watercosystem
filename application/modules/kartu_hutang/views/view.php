<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kartu Hutang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        .detail-value {
            color: #212529;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-file-alt"></i> Detail Data Kartu Hutang</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="detail-label">ID</div>
                            <div class="detail-value"><?php echo $kartu_hutang->id; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Tipe</div>
                            <div class="detail-value"><?php echo $kartu_hutang->tipe; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Nomor</div>
                            <div class="detail-value"><?php echo $kartu_hutang->nomor; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Tanggal</div>
                            <div class="detail-value"><?php echo date('d-m-Y', strtotime($kartu_hutang->tanggal)); ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">No Perkiraan</div>
                            <div class="detail-value"><?php echo $kartu_hutang->no_perkiraan; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Keterangan</div>
                            <div class="detail-value"><?php echo $kartu_hutang->keterangan ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Jenis Transaksi</div>
                            <div class="detail-value"><?php echo $kartu_hutang->jenis_trans; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">No Referensi</div>
                            <div class="detail-value"><?php echo $kartu_hutang->no_reff ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Debet</div>
                            <div class="detail-value text-right">
                                <strong class="text-success">Rp <?php echo number_format($kartu_hutang->debet, 2, ',', '.'); ?></strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Kredit</div>
                            <div class="detail-value text-right">
                                <strong class="text-danger">Rp <?php echo number_format($kartu_hutang->kredit, 2, ',', '.'); ?></strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Debet USD</div>
                            <div class="detail-value text-right">
                                <strong class="text-success">$ <?php echo number_format($kartu_hutang->debet_usd, 2, ',', '.'); ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="detail-label">Kredit USD</div>
                            <div class="detail-value text-right">
                                <strong class="text-danger">$ <?php echo number_format($kartu_hutang->kredit_usd, 2, ',', '.'); ?></strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">No Customer</div>
                            <div class="detail-value"><?php echo $kartu_hutang->nocust ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Valid</div>
                            <div class="detail-value">
                                <?php if($kartu_hutang->valid == 'Y'): ?>
                                    <span class="badge badge-success">Ya</span>
                                <?php elseif($kartu_hutang->valid == 'N'): ?>
                                    <span class="badge badge-danger">Tidak</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">-</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Waktu Valid</div>
                            <div class="detail-value">
                                <?php echo $kartu_hutang->waktu_valid ? date('d-m-Y H:i:s', strtotime($kartu_hutang->waktu_valid)) : '-'; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Status Pos</div>
                            <div class="detail-value"><?php echo $kartu_hutang->stspos ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Jenis Jurnal</div>
                            <div class="detail-value"><?php echo $kartu_hutang->jenis_jurnal ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">ID Supplier</div>
                            <div class="detail-value"><?php echo $kartu_hutang->id_supplier ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Nama Supplier</div>
                            <div class="detail-value"><?php echo $kartu_hutang->nama_supplier ?: '-'; ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">No Request</div>
                            <div class="detail-value"><?php echo $kartu_hutang->no_request ?: '-'; ?></div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="mt-4">
                    <a href="<?php echo base_url('kartu_hutang/edit/'.$kartu_hutang->id); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo base_url('kartu_hutang'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="<?php echo base_url('kartu_hutang/delete/'.$kartu_hutang->id); ?>" 
                       class="btn btn-danger float-right" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>