<?php $title = 'Dashboard Pembeli - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-4"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card rounded-4 shadow-sm p-4">
                    <h2 class="fw-bold mb-3">Dashboard Buyer</h2>
                    <p class="text-muted mb-4">Kelola pencarian Anda dan temukan properti yang paling sesuai.</p>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 rounded-4 shadow-sm p-3 h-100">
                                <h6 class="mb-2">Properti Favorit</h6>
                                <p class="display-6 fw-bold mb-0">0</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 rounded-4 shadow-sm p-3 h-100">
                                <h6 class="mb-2">Properti Terbaru</h6>
                                <p class="display-6 fw-bold mb-0"><?= count($recommendedProperties) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 rounded-4 shadow-sm p-3 h-100">
                                <h6 class="mb-2">Simulasi Harga</h6>
                                <p class="display-6 fw-bold mb-0">Tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold mb-3">Riwayat Pencarian</h5>
                    <p class="text-muted mb-3">Belum ada pencarian tersimpan. Mulai jelajahi properti untuk merekam riwayat pencarian Anda.</p>
                    <a href="<?= site_url('search') ?>" class="btn btn-primary w-100">Cari Properti</a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card rounded-4 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="h5 fw-bold mb-0">Rekomendasi Properti</h3>
                            <p class="text-muted mb-0">Properti terbaru yang mungkin cocok untuk Anda.</p>
                        </div>
                        <a href="<?= site_url('search') ?>" class="text-decoration-none">Lihat Semua</a>
                    </div>
                    <?php if (empty($recommendedProperties)): ?>
                        <div class="text-center py-5 text-muted">Tidak ada rekomendasi saat ini.</div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($recommendedProperties as $property): ?>
                                <div class="col-md-6">
                                    <?= $this->include('components/property-card', ['property' => $property]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4">
                    <h5 class="fw-semibold mb-3">Simulasi Harga</h5>
                    <p class="text-muted mb-4">Gunakan kalkulator KPR untuk mengetahui estimasi cicilan dan total pembayaran.</p>
                    <a href="<?= site_url('kalkulator-harga') ?>" class="btn btn-outline-primary w-100">Buka Kalkulator</a>
                </div>
            </aside>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
