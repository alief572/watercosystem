<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kartu Hutang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Data Kartu Hutang</h4>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo base_url('kartu_hutang/store'); ?>" method="post">
                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe">Tipe <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tipe" name="tipe" maxlength="3" required>
                            </div>

                            <div class="form-group">
                                <label for="nomor">Nomor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor" name="nomor" maxlength="50" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            <div class="form-group">
                                <label for="no_perkiraan">No Perkiraan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" maxlength="10" required>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" maxlength="150"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="jenis_trans">Jenis Transaksi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jenis_trans" name="jenis_trans" maxlength="20" required>
                            </div>

                            <div class="form-group">
                                <label for="no_reff">No Referensi</label>
                                <input type="text" class="form-control" id="no_reff" name="no_reff" maxlength="25">
                            </div>

                            <div class="form-group">
                                <label for="debet">Debet</label>
                                <input type="number" step="0.01" class="form-control" id="debet" name="debet" value="0">
                            </div>

                            <div class="form-group">
                                <label for="kredit">Kredit</label>
                                <input type="number" step="0.01" class="form-control" id="kredit" name="kredit" value="0">
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="debet_usd">Debet USD</label>
                                <input type="number" step="0.01" class="form-control" id="debet_usd" name="debet_usd" value="0">
                            </div>

                            <div class="form-group">
                                <label for="kredit_usd">Kredit USD</label>
                                <input type="number" step="0.01" class="form-control" id="kredit_usd" name="kredit_usd" value="0">
                            </div>

                            <div class="form-group">
                                <label for="nocust">No Customer</label>
                                <input type="text" class="form-control" id="nocust" name="nocust" maxlength="15">
                            </div>

                            <div class="form-group">
                                <label for="valid">Valid</label>
                                <select class="form-control" id="valid" name="valid">
                                    <option value="">-- Pilih --</option>
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="waktu_valid">Waktu Valid</label>
                                <input type="datetime-local" class="form-control" id="waktu_valid" name="waktu_valid">
                            </div>

                            <div class="form-group">
                                <label for="stspos">Status Pos</label>
                                <input type="text" class="form-control" id="stspos" name="stspos" maxlength="1">
                            </div>

                            <div class="form-group">
                                <label for="jenis_jurnal">Jenis Jurnal</label>
                                <input type="text" class="form-control" id="jenis_jurnal" name="jenis_jurnal" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label for="id_supplier">ID Supplier</label>
                                <input type="text" class="form-control" id="id_supplier" name="id_supplier" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label for="nama_supplier">Nama Supplier</label>
                                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label for="no_request">No Request</label>
                                <input type="text" class="form-control" id="no_request" name="no_request" maxlength="25">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo base_url('kartu_hutang'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>