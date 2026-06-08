<?php $title = esc($property['title']) . ' - OMNIHOUSE'; ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-4">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/search">Cari Properti</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($property['title']) ?></li>
      </ol>
    </nav>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 p-3">
          <img id="mainImage" src="<?= esc(imageUrl($images[0]['image_path'] ?? propertyPlaceholder())) ?>" class="img-fluid rounded-4" alt="Foto properti utama" loading="lazy" style="height: 420px; object-fit: cover; width: 100%;">
          <div class="row g-2 mt-3">
            <?php foreach ($images as $img): ?>
              <div class="col-3">
                <img src="<?= esc(imageUrl($img['image_path'])) ?>" class="img-fluid rounded-3 thumb-image" style="height: 90px; object-fit: cover; width: 100%; cursor: pointer;" alt="Thumbnail properti" loading="lazy">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 p-4 sticky-top" style="top: 1rem;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-primary-subtle text-primary text-uppercase"><?= esc($property['type']) ?></span>
            <span class="badge bg-success-subtle text-success text-uppercase"><?= esc($property['status']) ?></span>
          </div>
          <h1 class="h3 fw-bold mb-2"><?= esc($property['title']) ?></h1>
          <p class="text-muted mb-3"><i class="bi bi-geo-alt"></i> <?= esc($property['city']) ?>, <?= esc($property['address']) ?></p>
          <h2 class="text-success fw-bold mb-4"><?= formatRupiah($property['price']) ?></h2>

          <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item d-flex justify-content-between"><span>Kamar Tidur</span><strong><?= esc($property['bedrooms'] ?? '-') ?></strong></li>
            <li class="list-group-item d-flex justify-content-between"><span>Kamar Mandi</span><strong><?= esc($property['bathrooms'] ?? '-') ?></strong></li>
            <li class="list-group-item d-flex justify-content-between"><span>Luas Tanah</span><strong><?= esc($property['land_area'] ?? '-') ?> m²</strong></li>
            <li class="list-group-item d-flex justify-content-between"><span>Luas Bangunan</span><strong><?= esc($property['building_area'] ?? '-') ?> m²</strong></li>
          </ul>

          <a href="<?= esc($waLink) ?>" target="_blank" class="btn btn-success w-100 mb-2">Chat via WhatsApp</a>
          <?php if (session()->get('user_id')): ?>
            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#chatModal">Kirim Pesan</button>
          <?php else: ?>
            <a href="/login" class="btn btn-outline-primary w-100">Login untuk Chat</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="row g-4 mt-1">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 p-4">
          <h4 class="h5 fw-bold mb-3">Deskripsi Properti</h4>
          <p class="text-muted mb-0"><?= esc($property['description']) ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 p-4">
          <h4 class="h5 fw-bold mb-3">Lokasi</h4>
          <p class="mb-0 text-muted"><?= esc($property['address']) ?>, <?= esc($property['city']) ?></p>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <h3 class="h4 fw-bold mb-3">Properti Terkait</h3>
      <div class="row g-4">
        <?php foreach ($relatedProperties as $item): ?>
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
              <img src="<?= esc(imageUrl($item['image'] ?? propertyPlaceholder())) ?>" class="card-img-top" style="height: 160px; object-fit: cover;" alt="Properti terkait" loading="lazy">
              <div class="card-body">
                <h6 class="fw-semibold mb-1"><?= esc($item['title']) ?></h6>
                <p class="small text-muted mb-2"><?= esc($item['city']) ?></p>
                <p class="text-success fw-bold mb-0"><?= formatRupiah($item['price']) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?php if (session()->get('user_id')): ?>
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="chatModalLabel">Kirim Pesan ke Penjual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <textarea id="messageInput" class="form-control" rows="4" placeholder="Tulis pesan Anda disini..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="sendMessage()">Kirim</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  document.querySelectorAll('.thumb-image').forEach(function (img) {
    img.addEventListener('click', function () {
      document.getElementById('mainImage').src = this.src;
    });
  });

  function sendMessage() {
    const message = document.getElementById('messageInput').value;
    fetch('/property/<?= $property['id'] ?>/contact', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'message=' + encodeURIComponent(message)
    }).then(res => res.json()).then(data => {
      alert(data.message || 'Pesan terkirim');
      if (data.success) {
        const modal = bootstrap.Modal.getInstance(document.getElementById('chatModal'));
        modal.hide();
        document.getElementById('messageInput').value = '';
      }
    });
  }
</script>
<?= $this->endSection() ?>
