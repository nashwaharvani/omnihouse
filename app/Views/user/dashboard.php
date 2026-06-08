<?php $title = 'Dashboard Pembeli - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <h2 class="fw-bold mb-3">Dashboard Pembeli</h2>
  <p class="text-muted">Riwayat pesan Anda:</p>
  <div class="card shadow-sm border-0 rounded-4 p-3">
    <ul class="list-group list-group-flush">
      <?php foreach ($messages as $msg): ?>
        <li class="list-group-item"><strong><?= esc($msg['message']) ?></strong><br><small class="text-muted">Dikirim: <?= esc($msg['created_at']) ?></small></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?= $this->endSection() ?>
