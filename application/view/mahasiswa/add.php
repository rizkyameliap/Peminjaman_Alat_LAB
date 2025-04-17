<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Data Mahasiswa</h4>
            </div>
            <div class="card-body">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>
                
                <?= form_open('mahasiswa/add') ?>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" name="program_studi" id="program_studi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">No. Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('mahasiswa') ?>" class="btn btn-secondary">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>