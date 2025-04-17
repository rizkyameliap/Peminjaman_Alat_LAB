<?php $this->load->view('layout/header'); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('layout/sidebar'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Data Alat</h4>
            </div>
            <div class="card-body">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>
                
                <?= form_open('alat/add') ?>
                    <div class="form-group">
                        <label for="kode_alat">Kode Alat</label>
                        <input type="text" name="kode_alat" id="kode_alat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_alat">Nama Alat</label>
                        <input type="text" name="nama_alat" id="nama_alat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">- Pilih Kategori -</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Mekanik">Mekanik</option>
                            <option value="Optik">Optik</option>
                            <option value="Kimia">Kimia</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" id="kondisi" class="form-control" required>
                            <option value="">- Pilih Kondisi -</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('alat') ?>" class="btn btn-secondary">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>