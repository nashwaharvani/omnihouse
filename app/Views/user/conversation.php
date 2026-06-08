<?php $title = 'Conversation - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 p-4">
    <h4 class="fw-bold mb-1">Percakapan dengan <?= esc($other['name'] ?? '') ?></h4>
    <p class="text-muted mb-4">Properti: <?= esc($property['title'] ?? '') ?></p>
    <div class="border rounded-4 p-3 mb-3 bg-white" style="min-height: 300px;">
      <?php foreach ($thread as $msg): ?>
        <div class="mb-3">
          <div class="fw-semibold small text-muted"><?= esc($msg['sender_name'] ?? 'User') ?></div>
          <div class="p-3 rounded-4 bg-light d-inline-block"><?= esc($msg['message']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    <form action="/messages/send" method="post" class="row g-2">
      <?= csrf_field() ?>
      <input type="hidden" name="property_id" value="<?= esc($property['id']) ?>">
      <input type="hidden" name="receiver_id" value="<?= esc($other['id']) ?>">
      <div class="col"><input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required></div>
      <div class="col-auto"><button class="btn btn-primary" type="submit">Kirim</button></div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
