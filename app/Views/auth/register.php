<?php $title = 'Daftar - OMNIHOUSE' ?>
<?= $this->extend('layouts/auth') ?>
<?= $this->section('auth-content') ?>
    <?php $role = old('role', service('request')->getGet('role') ?? 'buyer'); ?>
    <p class="text-muted mb-4"><?= $role === 'seller' ? 'Daftar sebagai penjual untuk mulai unggah properti.' : 'Daftar sebagai pembeli untuk mulai mencari properti.' ?></p>

    <div class="mb-3">
        <label class="form-label">Daftar Sebagai</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="roleBuyer" value="buyer" <?= $role === 'buyer' ? 'checked' : '' ?> />
            <label class="form-check-label" for="roleBuyer">Buyer</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="roleSeller" value="seller" <?= $role === 'seller' ? 'checked' : '' ?> />
            <label class="form-check-label" for="roleSeller">Seller</label>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="/register">
        <?= csrf_field() ?>
        <input type="hidden" name="role" value="<?= esc($role) ?>">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Daftar</button>
    </form>

    <p class="mt-3 text-center mb-0">
        Sudah punya akun? <a href="/login">Login</a>
    </p>
<?= $this->endSection() ?>
