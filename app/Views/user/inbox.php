<?php $title = 'Inbox - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="row g-0" style="min-height: 75vh;">
      <aside class="col-lg-4 border-end bg-white p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold mb-0">Inbox</h4>
          <a href="/user/profile" class="btn btn-sm btn-outline-secondary">Profil</a>
        </div>
        <?php foreach ($conversations as $c): ?>
          <a href="/user/conversation/<?= $c['property_id'] ?>/<?= $c['other_id'] ?>" class="text-decoration-none text-dark">
            <div class="border rounded-4 p-3 mb-2 hover-bg-light">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <strong><?= esc($c['property_title'] ?? 'Properti') ?></strong>
                  <div class="small text-muted"><?= esc($c['other_name']) ?></div>
                </div>
                <?php if ($c['unread'] > 0): ?>
                  <span class="badge bg-danger rounded-pill"><?= $c['unread'] ?></span>
                <?php endif; ?>
              </div>
              <p class="mb-0 small text-muted mt-2"><?= esc($c['last_message']) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </aside>
      <section class="col-lg-8 bg-light p-4">
        <div class="text-center text-muted py-5">
          <i class="bi bi-chat-dots fs-1"></i>
          <h5 class="mt-3">Pilih percakapan di sebelah kiri</h5>
          <p class="mb-0">Lihat semua diskusi properti dan balasan dari penjual.</p>
        </div>
      </section>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
