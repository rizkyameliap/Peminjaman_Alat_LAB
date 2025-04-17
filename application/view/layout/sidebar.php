<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Menu</h5>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <?php if($this->session->userdata('role') == 'admin'): ?>
                <li class="list-group-item">
                    <a href="<?= base_url('dashboard') ?>" class="text-decoration-none">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?= base_url('mahasiswa') ?>" class="text-decoration-none">
                        <i class="fas fa-users mr-2"></i> Data Mahasiswa
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?= base_url('alat') ?>" class="text-decoration-none">
                        <i class="fas fa-tools mr-2"></i> Data Alat
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?= base_url('booking') ?>" class="text-decoration-none">
                        <i class="fas fa-clipboard-list mr-2"></i> Data Peminjaman
                    </a>
                </li>
            <?php else: ?>
                <li class="list-group-item">
                    <a href="<?= base_url('booking') ?>" class="text-decoration-none">
                        <i class="fas fa-clipboard-list mr-2"></i> Peminjaman Alat
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?= base_url('booking/riwayat') ?>" class="text-decoration-none">
                        <i class="fas fa-history mr-2"></i> Riwayat Peminjaman
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>