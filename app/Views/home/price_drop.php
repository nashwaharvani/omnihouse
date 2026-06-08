<?php $title = 'Properti Turun Harga - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-primary mb-3">Promo Properti</span>
                <h1 class="display-5 fw-bold">Temukan Properti Turun Harga</h1>
                <p class="lead text-white-75">Daftar properti dengan harga promo dan diskon menarik. Temukan hunian terbaik tanpa meninggalkan anggaran.</p>
                <a href="<?= site_url('search') ?>" class="btn btn-light btn-lg mt-3">Cari Properti Lainnya</a>
            </div>
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden shadow-sm">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80" class="img-fluid" alt="Properti Diskon">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Penawaran Turun Harga</h2>
                <p class="text-muted mb-0">Properti unggulan dengan potongan harga terbaik dari database kami.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">Menampilkan <?= count($properties) ?> listing</span>
        </div>

        <?php if (empty($properties)): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <h5 class="fw-semibold mb-2">Belum ada properti promo tersedia</h5>
                <p class="text-muted mb-0">Silakan coba lagi nanti atau gunakan fitur pencarian untuk menemukan listing lain.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            <img src="<?= esc(imageUrl($property['image'] ?? propertyPlaceholder())) ?>" class="card-img-top" alt="<?= esc($property['title']) ?>" loading="lazy" style="height: 220px; object-fit: cover;" onerror="this.onerror=null; this.src='<?= esc(propertyPlaceholder()) ?>';">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-danger text-white">Diskon <?= esc($property['discount_pct']) ?>%</span>
                                    <span class="badge bg-primary-subtle text-primary text-uppercase"><?= esc($property['type']) ?></span>
                                </div>
                                <h5 class="card-title mb-2 fw-semibold"><?= esc($property['title']) ?></h5>
                                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i><?= esc($property['city']) ?></p>
                                <p class="mb-2"><span class="text-muted text-decoration-line-through"><?= formatRupiah($property['original_price']) ?></span></p>
                                <p class="fw-bold text-success mb-3"><?= formatRupiah($property['price']) ?></p>
                                <div class="mt-auto">
                                    <a href="<?= site_url('properti/' . $property['id']) ?>" class="btn btn-outline-primary w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
