<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Dashboard Admin</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Jumlah Mahasiswa</h6>
                                        <h2 class="mb-0"><?= $jumlah_mahasiswa ?></h2>
                                    </div>
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="<?= base_url('mahasiswa') ?>" class="text-primary">Detail <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Jumlah Alat</h6>
                                        <h2 class="mb-0"><?= $jumlah_alat ?></h2>
                                    </div>
                                    <i class="fas fa-tools fa-3x"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="<?= base_url('alat') ?>" class="text-success">Detail <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Peminjaman Aktif</h6>
                                        <h2 class="mb-0"><?= $peminjaman_aktif ?></h2>
                                    </div>
                                    <i class="fas fa-clipboard-list fa-3x"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="<?= base_url('booking') ?>" class="text-warning">Detail <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Peminjaman Terbaru yang Menunggu Persetujuan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Alat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($peminjaman_pending)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data peminjaman yang menunggu persetujuan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach($peminjaman_pending as $pending): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d/m/Y', strtotime($pending->tanggal_pinjam)) ?></td>
                                                <td><?= $pending->nim ?></td>
                                                <td><?= $pending->nama_mahasiswa ?></td>
                                                <td><?= $pending->nama_alat ?></td>
                                                <td>
                                                    <span class="badge badge-warning">Menunggu</span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('booking/detail/'.$pending->id_booking) ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Detail
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
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>