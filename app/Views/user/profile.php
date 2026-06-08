<?php $title = 'Edit Profil - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 p-4">
    <h3 class="fw-bold">Edit Profil</h3>
    <form method="post" enctype="multipart/form-data" action="/user/profil">
      <?= csrf_field() ?>
      <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>"></div>
      <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>"></div>
      <div class="mb-3"><label class="form-label">Nomor HP</label><input type="text" name="phone" class="form-control" value="<?= esc($user['phone']) ?>"></div>
      <div class="mb-3"><label class="form-label">Avatar</label><input type="file" name="avatar" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Password Lama</label><input type="password" name="old_password" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control"></div>
      <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
