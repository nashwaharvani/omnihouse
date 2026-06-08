<?php $title = 'Tambah Properti - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 p-4">
    <h3 class="fw-bold mb-1">Tambah Properti</h3>
    <p class="text-muted mb-4">Isi data properti dengan lengkap.</p>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?= site_url('seller/properti/tambah') ?>">
      <?= csrf_field() ?>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Judul Properti</label><input type="text" name="title" class="form-control" required value="<?= old('title') ?>"></div>
        <div class="col-md-6"><label class="form-label">Harga</label><input type="number" name="price" class="form-control" required value="<?= old('price') ?>"></div>
        <div class="col-md-6"><label class="form-label">Tipe Properti</label><select name="type" class="form-select" required><option value="">Pilih</option><option value="rumah">Rumah</option><option value="kontrakan">Kontrakan</option><option value="apartemen">Apartemen</option><option value="kost">Kost</option><option value="ruko">Ruko</option><option value="tanah">Tanah</option></select></div>
        <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="dijual">Dijual</option><option value="disewa">Disewa</option></select></div>
        <div class="col-md-6"><label class="form-label">Kota</label><input type="text" name="city" class="form-control" required value="<?= old('city') ?>"></div>
        <div class="col-md-6"><label class="form-label">Provinsi</label><input type="text" name="province" class="form-control" required value="<?= old('province') ?>"></div>
        <div class="col-md-6"><label class="form-label">Nama Kontak</label><input type="text" name="contact_name" class="form-control" required value="<?= old('contact_name') ?>"></div>
        <div class="col-md-6"><label class="form-label">Email Kontak</label><input type="email" name="contact_email" class="form-control" required value="<?= old('contact_email') ?>"></div>
        <div class="col-md-6"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp_number" class="form-control" required placeholder="Contoh: 08123456789" value="<?= old('whatsapp_number') ?>"></div>
        <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2" required><?= old('address') ?></textarea></div>
        <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4" required><?= old('description') ?></textarea></div>
        <div class="col-md-3"><label class="form-label">Kamar Tidur</label><input type="number" name="bedrooms" class="form-control" value="<?= old('bedrooms') ?>"></div>
        <div class="col-md-3"><label class="form-label">Kamar Mandi</label><input type="number" name="bathrooms" class="form-control" value="<?= old('bathrooms') ?>"></div>
        <div class="col-md-3"><label class="form-label">Luas Tanah (m²)</label><input type="number" name="land_area" class="form-control" value="<?= old('land_area') ?>"></div>
        <div class="col-md-3"><label class="form-label">Luas Bangunan (m²)</label><input type="number" name="building_area" class="form-control" value="<?= old('building_area') ?>"></div>

        <div class="col-12">
          <label class="form-label">Foto Properti</label>
          <input type="file" id="imagesInput" name="images[]" class="form-control" multiple accept="image/*">
          <div id="preview" class="row g-2 mt-3"></div>
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Simpan Properti</button>
        <a href="/seller/dashboard" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  const input = document.getElementById('imagesInput');
  const preview = document.getElementById('preview');
  input.addEventListener('change', function () {
    preview.innerHTML = '';
    Array.from(this.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const div = document.createElement('div');
        div.className = 'col-3';
        div.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded-3" style="height: 90px; object-fit: cover; width: 100%;">';
        preview.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  });
</script>
<?= $this->endSection() ?>
