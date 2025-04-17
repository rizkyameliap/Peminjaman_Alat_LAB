<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Selamat datang di Panel Admin Sistem Peminjaman Alat Praktikum. Kelola data mahasiswa, alat, dan peminjaman di sini.
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary p-3 me-3">
                    <i class="fas fa-users text-white fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-0">Total Mahasiswa</h5>
                    <h3 class="mb-0"><?= $mahasiswa_count ?></h3>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="<?= base_url('mahasiswa') ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success p-3 me-3">
                    <i class="fas fa-tools text-white fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-0">Total Alat</h5>
                    <h3 class="mb-0"><?= $alat_count ?></h3>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="<?= base_url('alat') ?>" class="btn btn-sm btn-outline-success">Lihat Detail</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-warning p-3 me-3">
                    <i class="fas fa-hourglass-half text-white fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-0">Peminjaman Menunggu</h5>
                    <h3 class="mb-0"><?= count($pending_bookings) ?></h3>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="<?= base_url('booking') ?>" class="btn btn-sm btn-outline-warning">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Peminjaman Menunggu Verifikasi</h5>
            </div>
            <div class="card-body">
                <?php if (empty($pending_bookings)): ?>
                <div class="alert alert-info">
                    Tidak ada peminjaman yang menunggu verifikasi.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nama Alat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pending_bookings as $booking): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $booking->nim ?></td>
                                <td><?= $booking->nama_mahasiswa ?></td>
                                <td><?= $booking->nama_alat ?></td>
                                <td><?= date('d M Y', strtotime($booking->tanggal_pinjam)) ?></td>
                                <td><?= date('d M Y', strtotime($booking->tanggal_kembali)) ?></td>
                                <td><?= $booking->jumlah ?></td>
                                <td>
                                    <a href="<?= base_url('booking/detail/'.$booking->id_booking) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="<?= base_url('booking/approve/'.$booking->id_booking) ?>" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                                        <i class="fas fa-check"></i> Setuju
                                    </a>
                                    <a href="<?= base_url('booking/reject/'.$booking->id_booking) ?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i> Tolak
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>