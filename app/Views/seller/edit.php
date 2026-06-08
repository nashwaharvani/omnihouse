<?php $title = 'Edit Properti - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 p-4">
    <h3 class="fw-bold mb-1">Edit Properti</h3>
    <p class="text-muted mb-4">Perbarui informasi properti Anda.</p>
    <form method="post" enctype="multipart/form-data" action="<?= site_url('seller/properti/edit/' . $property['id']) ?>">
      <?= csrf_field() ?>
      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Judul Properti</label><input type="text" name="title" class="form-control" required value="<?= old('title', esc($property['title'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">Harga</label><input type="number" name="price" class="form-control" required value="<?= old('price', esc($property['price'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">Tipe Properti</label><select name="type" class="form-select" required><option value="rumah" <?= old('type', $property['type']) === 'rumah' ? 'selected' : '' ?>>Rumah</option><option value="kontrakan" <?= old('type', $property['type']) === 'kontrakan' ? 'selected' : '' ?>>Kontrakan</option><option value="apartemen" <?= old('type', $property['type']) === 'apartemen' ? 'selected' : '' ?>>Apartemen</option><option value="kost" <?= old('type', $property['type']) === 'kost' ? 'selected' : '' ?>>Kost</option><option value="ruko" <?= old('type', $property['type']) === 'ruko' ? 'selected' : '' ?>>Ruko</option><option value="tanah" <?= old('type', $property['type']) === 'tanah' ? 'selected' : '' ?>>Tanah</option></select></div>
        <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="dijual" <?= old('status', $property['status']) === 'dijual' ? 'selected' : '' ?>>Dijual</option><option value="disewa" <?= old('status', $property['status']) === 'disewa' ? 'selected' : '' ?>>Disewa</option></select></div>
        <div class="col-md-6"><label class="form-label">Kota</label><input type="text" name="city" class="form-control" required value="<?= old('city', esc($property['city'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">Provinsi</label><input type="text" name="province" class="form-control" required value="<?= old('province', esc($property['province'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">Nama Kontak</label><input type="text" name="contact_name" class="form-control" required value="<?= old('contact_name', esc($property['contact_name'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">Email Kontak</label><input type="email" name="contact_email" class="form-control" required value="<?= old('contact_email', esc($property['contact_email'])) ?>"></div>
        <div class="col-md-6"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp_number" class="form-control" required value="<?= old('whatsapp_number', esc($property['whatsapp_number'])) ?>"></div>
        <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2" required><?= old('address', esc($property['address'])) ?></textarea></div>
        <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4" required><?= old('description', esc($property['description'])) ?></textarea></div>
        <div class="col-md-3"><label class="form-label">Kamar Tidur</label><input type="number" name="bedrooms" class="form-control" value="<?= esc($property['bedrooms']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Kamar Mandi</label><input type="number" name="bathrooms" class="form-control" value="<?= esc($property['bathrooms']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Luas Tanah (m²)</label><input type="number" name="land_area" class="form-control" value="<?= esc($property['land_area']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Luas Bangunan (m²)</label><input type="number" name="building_area" class="form-control" value="<?= esc($property['building_area']) ?>"></div>
        <div class="col-12"><label class="form-label">Tambah Foto</label><input type="file" name="images[]" class="form-control" multiple accept="image/*"></div>
      </div>
      <div class="mt-4 d-flex gap-2"><button class="btn btn-primary" type="submit">Update Properti</button><a href="/seller/dashboard" class="btn btn-outline-secondary">Batal</a></div>
    </form>
  </div>
</div>
<?= $this->section('scripts') ?>
<script>
  const editForm = document.querySelector('form');
  const editSubmit = editForm.querySelector('button[type="submit"]');
  editForm.addEventListener('submit', function () {
    if (editSubmit) {
      editSubmit.disabled = true;
      editSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan ...';
    }
  });
</script>
<?= $this->endSection() ?>
