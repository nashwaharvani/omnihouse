<?php $title = 'Masuk Sebagai Pembeli - OMNIHOUSE' ?>
<?= $this->extend('layouts/auth') ?>
<?= $this->section('auth-content') ?>
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold">Masuk Sebagai Pembeli</h1>
        <p class="text-muted">Temukan properti impian Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login/buyer') ?>">
        <?= csrf_field() ?>
        <div class="mb-3 text-center">
            <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4" alt="Ilustrasi cari properti">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>

    <p class="mt-3 text-center mb-0">
        Belum punya akun? <a href="<?= site_url('register/buyer') ?>">Daftar sebagai Pembeli</a>
    </p>
<?= $this->endSection() ?>
