<?php $title = 'Dashboard Seller - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-1">Dashboard Penjual</h2>
      <p class="text-muted mb-0">Kelola iklan properti Anda.</p>
    </div>
    <a href="/seller/create" class="btn btn-primary">+ Tambah Properti</a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
    <div class="col"><div class="card p-3 shadow-sm"><strong><?= esc($totalProperties) ?></strong><div>Total Properti</div></div></div>
    <div class="col"><div class="card p-3 shadow-sm"><strong><?= esc($totalActive) ?></strong><div>Properti Aktif</div></div></div>
    <div class="col"><div class="card p-3 shadow-sm"><strong><?= esc($totalSold) ?></strong><div>Properti Terjual</div></div></div>
    <div class="col"><div class="card p-3 shadow-sm"><strong><?= formatRupiah($totalRevenue) ?></strong><div>Total Penjualan</div></div></div>
    <div class="col"><div class="card p-3 shadow-sm"><strong><?= esc($totalViews) ?></strong><div>Jumlah Pengunjung</div></div></div>
  </div>

  <div class="card shadow-sm border-0 rounded-4 p-3 mb-4 sales-chart-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h5 class="fw-semibold mb-1">Grafik Penjualan</h5>
        <p class="text-muted mb-0">Data terbaru 6 bulan terakhir</p>
      </div>
      <div class="sales-chart-legend">
        <span><span class="legend-dot legend-active"></span> Properti Aktif</span>
        <span><span class="legend-dot legend-sold"></span> Properti Terjual</span>
        <span><span class="legend-dot legend-revenue"></span> Pendapatan</span>
      </div>
    </div>

    <div class="sales-chart-grid">
      <?php $maxValue = max(array_merge(array_column($monthlyStats, 'active'), array_column($monthlyStats, 'sold'), [1])); ?>
      <?php foreach ($monthlyStats as $month): ?>
        <?php $activeHeight = (int) (($month['active'] / $maxValue) * 180); ?>
        <?php $soldHeight = (int) (($month['sold'] / $maxValue) * 180); ?>
        <div class="sales-chart-column">
          <div class="sales-chart-bar active" style="height: <?= esc($activeHeight) ?>px;">
            <span><?= esc($month['active']) ?> aktif</span>
          </div>
          <div class="sales-chart-bar sold" style="height: <?= esc($soldHeight) ?>px;">
            <span><?= esc($month['sold']) ?> terjual</span>
          </div>
          <div class="sales-chart-label"><?= esc($month['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-4">
      <div class="d-flex justify-content-between flex-wrap gap-3">
        <div class="text-muted">Pendapatan total: <strong><?= formatRupiah($totalRevenue) ?></strong></div>
        <div class="text-muted">Properti aktif: <strong><?= esc($totalActive) ?></strong></div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4 p-3">
    <h5 class="fw-semibold mb-3">Daftar Properti Saya</h5>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Judul</th>
            <th>Tipe</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Views</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($properties as $property): ?>
            <tr>
              <td>
                <img src="<?= esc(imageUrl($property['image'] ?? propertyPlaceholder())) ?>" alt="Foto properti" class="rounded-3" style="width: 80px; height: 60px; object-fit: cover;" onerror="this.onerror=null; this.src='<?= esc(propertyPlaceholder()) ?>';">
              </td>
              <td><?= esc($property['title']) ?></td>
              <td><?= esc($property['type']) ?></td>
              <td><?= formatRupiah($property['price']) ?></td>
              <td><?= esc($property['status']) ?></td>
              <td><?= esc($property['views']) ?></td>
              <td>
                <a href="/seller/edit/<?= $property['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                <a href="/seller/delete/<?= $property['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Nonaktifkan properti ini?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
