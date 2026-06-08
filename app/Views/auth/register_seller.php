<?php $title = 'Daftar Seller - OMNIHOUSE' ?>
<?= $this->extend('layouts/auth') ?>
<?= $this->section('auth-content') ?>
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold">Daftar sebagai Seller</h1>
        <p class="text-muted">Mulai pasang iklan dan kelola properti Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('register/seller') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" class="form-control" required value="<?= old('phone') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Agen / Perusahaan</label>
            <input type="text" name="agency_name" class="form-control" value="<?= old('agency_name') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Daftar Seller</button>
    </form>

    <p class="mt-3 text-center mb-0">
        Sudah punya akun? <a href="<?= site_url('login/seller') ?>">Login Seller</a>
    </p>
<?= $this->endSection() ?>
