<?php $title = 'Favorit Saya - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Daftar Favorit</h2>
                <p class="text-muted mb-0">Properti yang Anda favoritkan akan muncul di halaman ini.</p>
            </div>
            <a href="<?= site_url('search') ?>" class="btn btn-outline-primary">Cari Properti</a>
        </div>

        <div class="card rounded-4 shadow-sm p-4">
            <div class="text-center py-5">
                <i class="bi bi-heart-fill fs-1 text-danger mb-3"></i>
                <h5 class="fw-semibold">Belum ada properti favorit</h5>
                <p class="text-muted mb-0">Tambahkan properti ke favorit untuk melihatnya lagi di sini.</p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
