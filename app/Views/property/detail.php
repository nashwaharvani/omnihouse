<?php $title = esc($property['title']) . ' - OMNIHOUSE'; ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$dpRate = defined('ORDER_DP_RATE') ? (float) ORDER_DP_RATE : 0.1;
$dpAmount = (int) max(1, round(((float) ($property['price'] ?? 0)) * $dpRate));
$status = (string) ($property['status'] ?? '');
$statusBadgeClass = match ($status) {
  'dipesan' => 'bg-warning-subtle text-warning',
  'terjual' => 'bg-secondary-subtle text-secondary',
  default => 'bg-success-subtle text-success',
};
?>
<section class="py-4">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= site_url('') ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= site_url('search') ?>">Cari Properti</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($property['title']) ?></li>
      </ol>
    </nav>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 p-3">
          <img id="mainImage" src="<?= esc(imageUrl($images[0]['image_path'] ?? propertyPlaceholder())) ?>" class="img-fluid rounded-4" alt="Foto properti utama" loading="lazy" style="height: 420px; object-fit: cover; width: 100%;" onerror="this.onerror=null; this.src='<?= esc(propertyPlaceholder()) ?>'; console.warn('Gagal memuat gambar detail properti:', this.src);">
          <div class="row g-2 mt-3">
            <?php foreach ($images as $img): ?>
              <div class="col-3">
                <img src="<?= esc(imageUrl($img['image_path'])) ?>" class="img-fluid rounded-3 thumb-image" style="height: 90px; object-fit: cover; width: 100%; cursor: pointer;" alt="Thumbnail properti" loading="lazy" onerror="this.onerror=null; this.src='<?= esc(propertyPlaceholder()) ?>'; console.warn('Gagal memuat thumbnail properti:', this.src);">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 p-4 sticky-top" style="top: 1rem;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-primary-subtle text-primary text-uppercase"><?= esc($property['type']) ?></span>
            <span class="badge <?= esc($statusBadgeClass) ?> text-uppercase"><?= esc($status) ?></span>
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
          <?php if (!session()->get('user_id')): ?>
            <a href="<?= site_url('login') ?>" class="btn btn-primary w-100 mb-2">Login untuk Pesan</a>
          <?php elseif (!in_array(session()->get('role'), ['seller', 'admin'], true)): ?>
            <?php if (in_array(($property['status'] ?? ''), ['dipesan', 'terjual'], true)): ?>
              <button type="button" class="btn btn-outline-secondary w-100 mb-2" disabled><?= ($property['status'] ?? '') === 'terjual' ? 'Sudah Terjual' : 'Sudah Dipesan' ?></button>
            <?php else: ?>
              <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#orderModal">Pesan Properti</button>
            <?php endif; ?>
          <?php endif; ?>
          <?php if (session()->get('user_id')): ?>
            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#chatModal">Kirim Pesan</button>
          <?php else: ?>
            <a href="<?= site_url('login') ?>" class="btn btn-outline-primary w-100">Login untuk Chat</a>
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
              <img src="<?= esc(imageUrl($item['image'] ?? propertyPlaceholder())) ?>" class="card-img-top" style="height: 160px; object-fit: cover;" alt="Properti terkait" loading="lazy" onerror="this.onerror=null; this.src='<?= esc(propertyPlaceholder()) ?>'; console.warn('Gagal memuat gambar properti terkait:', this.src);">
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

<?php if (session()->get('user_id') && !in_array(session()->get('role'), ['seller', 'admin'], true) && !in_array(($property['status'] ?? ''), ['dipesan', 'terjual'], true)): ?>
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="orderModalLabel">Pemesanan Properti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="<?= site_url('properti/' . (int) $property['id'] . '/pesan') ?>">
        <div class="modal-body">
          <?= csrf_field() ?>
          <div class="alert alert-warning rounded-4 mb-3">
            Pembayaran masih simulasi untuk MVP. Setelah dibuat, properti akan berstatus dipesan.
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih jenis pembayaran</label>
            <div class="d-grid gap-2">
              <label class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                <span>
                  <span class="fw-semibold">DP</span>
                  <span class="text-muted ms-2"><?= formatRupiah((float) $dpAmount) ?></span>
                </span>
                <input class="form-check-input m-0" type="radio" name="payment_type" value="dp" checked>
              </label>
              <label class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                <span>
                  <span class="fw-semibold">Pelunasan</span>
                  <span class="text-muted ms-2"><?= formatRupiah((float) ($property['price'] ?? 0)) ?></span>
                </span>
                <input class="form-check-input m-0" type="radio" name="payment_type" value="pelunasan">
              </label>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-semibold" for="payment_method">Metode pembayaran</label>
            <select class="form-select" id="payment_method" name="payment_method">
              <option value="simulasi" selected>Simulasi</option>
              <option value="transfer">Transfer Bank</option>
              <option value="cash">Cash</option>
              <option value="gateway">Payment Gateway</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Buat Pemesanan</button>
        </div>
      </form>
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
    fetch('<?= site_url('property/' . (int) $property['id'] . '/contact') ?>', {
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
