<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Data Alat</h4>
            </div>
            <div class="card-body">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>
                
                <?= form_open('alat/edit/'.$alat->id) ?>
                    <div class="form-group">
                        <label for="kode_alat">Kode Alat</label>
                        <input type="text" name="kode_alat" id="kode_alat" class="form-control" value="<?= $alat->kode_alat ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_alat">Nama Alat</label>
                        <input type="text" name="nama_alat" id="nama_alat" class="form-control" value="<?= $alat->nama_alat ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select