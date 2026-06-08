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

  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong><?= esc($totalProperties) ?></strong><div>Total Properti</div></div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong><?= esc($totalViews) ?></strong><div>Total Views</div></div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong><?= esc($totalMessages) ?></strong><div>Total Pesan Masuk</div></div></div>
  </div>

  <div class="card shadow-sm border-0 rounded-4 p-3">
    <h5 class="fw-semibold mb-3">Daftar Properti Saya</h5>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
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
