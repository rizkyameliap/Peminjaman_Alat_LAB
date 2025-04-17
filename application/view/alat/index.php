<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Alat Praktikum</h4>
                <a href="<?= base_url('alat/add') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Alat
                </a>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('message')): ?>
                    <div class="alert alert-<?= $this->session->flashdata('message_type') ?>">
                        <?= $this->session->flashdata('message') ?>
                    </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok Tersedia</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($alat)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data alat</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($alat as $a): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $a->kode_alat ?></td>
                                        <td><?= $a->nama_alat ?></td>
                                        <td><?= $a->kategori ?></td>
                                        <td><?= $a->stok ?></td>
                                        <td>
                                            <?php if($a->kondisi == 'Baik'): ?>
                                                <span class="badge badge-success">Baik</span>
                                            <?php elseif($a->kondisi == 'Rusak Ringan'): ?>
                                                <span class="badge badge-warning">Rusak Ringan</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Rusak Berat</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $a->keterangan ?></td>
                                        <td>
                                            <a href="<?= base_url('alat/edit/'.$a->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('alat/delete/'.$a->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>