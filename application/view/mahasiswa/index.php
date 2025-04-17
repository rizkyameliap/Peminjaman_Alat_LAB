<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Mahasiswa</h4>
                <a href="<?= base_url('mahasiswa/add') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($mahasiswa)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mahasiswa</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($mahasiswa as $mhs): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $mhs->nim ?></td>
                                        <td><?= $mhs->nama ?></td>
                                        <td><?= $mhs->program_studi ?></td>
                                        <td><?= $mhs->email ?></td>
                                        <td><?= $mhs->telepon ?></td>
                                        <td>
                                            <a href="<?= base_url('mahasiswa/edit/'.$mhs->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('mahasiswa/delete/'.$mhs->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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