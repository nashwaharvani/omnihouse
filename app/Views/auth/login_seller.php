<?php $title = 'Masuk Sebagai Penjual - OMNIHOUSE' ?>
<?= $this->extend('layouts/auth') ?>
<?= $this->section('auth-content') ?>
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold">Masuk Sebagai Penjual</h1>
        <p class="text-muted">Kelola dan pasarkan properti Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="mb-3 text-center">
        <div class="p-4 rounded-4 bg-primary bg-opacity-10 mb-3">
            <h5 class="fw-semibold">Jangkau Ribuan Calon Pembeli</h5>
            <p class="text-muted mb-0">Pasarkan properti Anda dengan mudah.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1505692794403-4d8a065b290b?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4" alt="Ilustrasi penjual properti">
    </div>

    <form method="post" action="<?= site_url('login/seller') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="next" value="<?= esc($next ?? '/seller/properti/tambah') ?>">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Masuk Sebagai Seller</button>
    </form>

    <p class="mt-3 text-center mb-0">
        Belum punya akun? <a href="<?= site_url('register/seller') ?>">Daftar sebagai Seller</a>
    </p>
<?= $this->endSection() ?>
