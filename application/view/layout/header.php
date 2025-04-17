<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Peminjaman Alat Praktikum' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link:hover {
            color: rgba(255,255,255,1);
        }
        .sidebar .nav-link.active {
            color: white;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .alert-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <h3 class="text-center mb-4">SiPinjam</h3>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard/admin') ?>" class="nav-link <?= $this->uri->segment(2) == 'admin' ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('mahasiswa') ?>" class="nav-link <?= $this->uri->segment(1) == 'mahasiswa' ? 'active' : '' ?>">
                                <i class="fas fa-users me-2"></i> Data Mahasiswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('alat') ?>" class="nav-link <?= $this->uri->segment(1) == 'alat' ? 'active' : '' ?>">
                                <i class="fas fa-tools me-2"></i> Data Alat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('booking') ?>" class="nav-link <?= $this->uri->segment(1) == 'booking' && $this->uri->segment(2) == '' ? 'active' : '' ?>">
                                <i class="fas fa-clipboard-list me-2"></i> Data Peminjaman
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' && !$this->uri->segment(2) ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('booking/add') ?>" class="nav-link <?= $this->uri->segment(1) == 'booking' && $this->uri->segment(2) == 'add' ? 'active' : '' ?>">
                                <i class="fas fa-plus-circle me-2"></i> Ajukan Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('booking') ?>" class="nav-link <?= $this->uri->segment(1) == 'booking' && !$this->uri->segment(2) ? 'active' : '' ?>">
                                <i class="fas fa-history me-2"></i> Riwayat Peminjaman
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item mt-3">
                            <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><?= $title ?? 'Sistem Peminjaman Alat Praktikum' ?></h2>
                    <div>
                        <span>Selamat datang, <?= $this->session->userdata('nama') ?></span>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <span class="badge bg-warning ms-2">Admin</span>
                        <?php else: ?>
                        <span class="badge bg-info ms-2">Mahasiswa</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Flash Messages -->
                <div class="alert-container">
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= validation_errors() ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                </div>