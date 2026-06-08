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
        <span><span class="legend-dot legend-sales"></span> Properti Terjual</span>
      </div>
    </div>

    <?php
      $values = array_map(static fn ($row) => (int) ($row['sold'] ?? 0), $monthlyStats ?? []);
      $labels = array_map(static fn ($row) => (string) ($row['label'] ?? ''), $monthlyStats ?? []);
      $count = count($values);
      $maxValue = max(array_merge($values, [1]));

      $vbW = 720;
      $vbH = 240;
      $padX = 28;
      $padY = 22;
      $innerW = $vbW - ($padX * 2);
      $innerH = $vbH - ($padY * 2);
      $stepX = $count > 1 ? ($innerW / ($count - 1)) : 0;

      $points = [];
      $circles = [];
      for ($i = 0; $i < $count; $i++) {
          $v = (int) ($values[$i] ?? 0);
          $x = $padX + ($stepX * $i);
          $y = $padY + (($maxValue - $v) / $maxValue) * $innerH;
          $points[] = number_format($x, 2, '.', '') . ',' . number_format($y, 2, '.', '');
          $circles[] = ['x' => $x, 'y' => $y, 'v' => $v];
      }
      $polylinePoints = implode(' ', $points);
    ?>

    <div class="sales-line-wrap">
      <svg class="sales-line-chart" viewBox="0 0 <?= esc($vbW) ?> <?= esc($vbH) ?>" preserveAspectRatio="none" role="img" aria-label="Grafik penjualan 6 bulan">
        <line x1="<?= esc($padX) ?>" y1="<?= esc($vbH - $padY) ?>" x2="<?= esc($vbW - $padX) ?>" y2="<?= esc($vbH - $padY) ?>" stroke="rgba(148, 163, 184, 0.6)" stroke-width="2" />
        <polyline points="<?= esc($polylinePoints) ?>" fill="none" stroke="var(--primary)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
        <?php foreach ($circles as $c): ?>
          <circle cx="<?= esc($c['x']) ?>" cy="<?= esc($c['y']) ?>" r="5" fill="#ffffff" stroke="var(--primary)" stroke-width="3" />
        <?php endforeach; ?>
      </svg>

      <div class="sales-line-labels">
        <?php foreach ($labels as $i => $label): ?>
          <div class="sales-line-label" title="<?= esc($label) ?>">
            <div class="sales-line-value"><?= esc($values[$i] ?? 0) ?></div>
            <div class="sales-line-month"><?= esc($label) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mt-4">
      <div class="d-flex justify-content-between flex-wrap gap-3">
        <div class="text-muted">Pendapatan total: <strong><?= formatRupiah($totalRevenue) ?></strong></div>
        <div class="text-muted">Properti aktif: <strong><?= esc($totalActive) ?></strong></div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
    <h5 class="fw-semibold mb-3">Pemesanan Terbaru</h5>
    <?php if (empty($recentOrders ?? [])): ?>
      <div class="text-center py-4 text-muted">Belum ada pemesanan.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Properti</th>
              <th>Pembeli</th>
              <th>Jenis</th>
              <th>Nominal</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($recentOrders ?? []) as $order): ?>
              <tr>
                <td class="fw-semibold"><?= esc($order['property_title'] ?? '-') ?></td>
                <td><?= esc($order['buyer_name'] ?? '-') ?></td>
                <td class="text-capitalize"><?= esc($order['payment_type'] ?? '-') ?></td>
                <td><?= formatRupiah((float) ($order['amount'] ?? 0)) ?></td>
                <td class="text-muted"><?= esc($order['created_at'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
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
