<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Piutang - List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Data Kartu Hutang</h4>
            </div>
            <div class="card-body">
                <!-- Flash Messages -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Toolbar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <a href="<?php echo base_url('kartu_piutang/create'); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form method="get" action="<?php echo base_url('kartu_piutang'); ?>" class="form-inline float-right">
                            <input type="text" name="search" class="form-control mr-2" placeholder="Cari Nomor atau No Reff..." value="<?php echo $search; ?>">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                            <?php if($search): ?>
                                <a href="<?php echo base_url('kartu_piutang'); ?>" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>No Perkiraan</th>
                                <th>Keterangan</th>
                                <th>No Reff</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Supplier</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($kartu_piutang)): ?>
                                <?php 
                                $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                                foreach($kartu_piutang as $row): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row->nomor; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row->tanggal)); ?></td>
                                    <td><?php echo $row->no_perkiraan; ?></td>
                                    <td><?php echo $row->keterangan; ?></td>
                                    <td><?php echo $row->no_reff; ?></td>
                                    <td class="text-right"><?php echo number_format($row->debet, 2, ',', '.'); ?></td>
                                    <td class="text-right"><?php echo number_format($row->kredit, 2, ',', '.'); ?></td>
                                    <td><?php echo $row->nama_supplier; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo base_url('kartu_piutang/view/'.$row->id); ?>" 
                                               class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo base_url('kartu_piutang/edit/'.$row->id); ?>" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo base_url('kartu_piutang/delete/'.$row->id); ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" 
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>