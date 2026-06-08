<?php $title = 'OMNIHOUSE | Marketplace Properti' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="hero-section position-relative overflow-hidden">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white">
                <span class="badge rounded-pill bg-white text-primary mb-3">#SEMUDAHITU</span>
                <h1 class="display-5 fw-bold mb-3">Jual Beli dan Sewa Properti Jadi Mudah</h1>
                <p class="lead text-white-75 mb-4">Temukan hunian terbaik, pasang iklan dengan cepat, dan raih kesempatan properti terbaik hari ini.</p>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="/search" class="btn btn-light btn-lg">Cari Properti</a>
                    <a href="/jual-properti" class="btn btn-outline-light btn-lg">Iklankan Properti</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-lg rounded-4 border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-muted mb-1">Kategori</p>
                            <h5 class="mb-0">Dijual</h5>
                        </div>
                        <div class="text-end text-muted small">Cari yang cocok</div>
                    </div>
                    <form action="/search" method="get" class="mb-3">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control border-start-0" placeholder="Lokasi, keyword, area, project, developer">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Cari</button>
                    </form>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>Disewa</span>
                        <span>Properti Baru</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Solusi Properti untuk Anda</h2>
                <p class="text-muted mb-0">Akses fitur lengkap untuk mencari, memasang iklan, dan mendapatkan layanan properti.</p>
            </div>
        </div>
        <div class="row g-3">
            <?php $actions = [
                ['icon' => 'bi-search', 'title' => 'Carikan Properti', 'desc' => 'Cari hunian sesuai kebutuhan.','link' => '/search'],
                ['icon' => 'bi-megaphone-fill', 'title' => 'Iklankan Properti', 'desc' => 'Pasang iklan jual atau sewa dengan mudah.','link' => '/jual-properti'],
                ['icon' => 'bi-people-fill', 'title' => 'Cari Agen', 'desc' => 'Temukan agen properti terpercaya.','link' => '/search'],
                ['icon' => 'bi-percent', 'title' => 'Properti Turun Harga', 'desc' => 'Penawaran spesial harian.','link' => '/search'],
                ['icon' => 'bi-calculator-fill', 'title' => 'Kalkulator KPR', 'desc' => 'Hitung cicilan rumah Anda.','link' => '/search'],
                ['icon' => 'bi-arrow-repeat', 'title' => 'Pindah KPR', 'desc' => 'Maksimalkan opsi take over.','link' => '/search'],
                ['icon' => 'bi-chat-dots-fill', 'title' => 'Tanya Forum', 'desc' => 'Dapatkan jawaban dari komunitas.','link' => '/search'],
                ['icon' => 'bi-grid-3x3-gap-fill', 'title' => 'Lainnya', 'desc' => 'Jelajahi layanan properti lainnya.','link' => '/search'],
            ];
            foreach ($actions as $action): ?>
                <div class="col-6 col-md-3">
                    <a href="<?= esc($action['link']) ?>" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 hover-shadow">
                            <div class="icon-box bg-primary text-white mb-3">
                                <i class="bi <?= esc($action['icon']) ?> fs-3"></i>
                            </div>
                            <h6 class="fw-semibold mb-2"><?= esc($action['title']) ?></h6>
                            <p class="small text-muted mb-0"><?= esc($action['desc']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="p-4 rounded-4 bg-white shadow-sm">
                    <h3 class="fw-bold mb-3">Promosi Unggulan</h3>
                    <p class="text-muted mb-4">Dapatkan promo eksklusif untuk properti pilihan dan layanan terbaik setiap bulan.</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="promo-card rounded-4 p-3 bg-primary text-white h-100">
                                <h5 class="mb-2">Diskon Biaya Admin</h5>
                                <p class="small">Potongan biaya khusus untuk pemasangan iklan.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="promo-card rounded-4 p-3 bg-white border h-100">
                                <h5 class="mb-2">KPR Bunga Ringan</h5>
                                <p class="small text-muted">Program cicilan dengan suku bunga kompetitif.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="promo-card rounded-4 p-3 bg-white border h-100">
                                <h5 class="mb-2">Properti Baru</h5>
                                <p class="small text-muted">Listing proyek baru hadir setiap minggu.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="promo-card rounded-4 p-3 bg-primary text-white h-100">
                                <h5 class="mb-2">Bantuan Agen Gratis</h5>
                                <p class="small">Konsultasi gratis untuk pilih properti ideal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden shadow-sm">
                    <img src="https://images.unsplash.com/photo-1560185127-6e5b06f4c1d6?auto=format&fit=crop&w=1200&q=80" class="img-fluid" alt="Promo Properti">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Properti Terbaru</h2>
                <p class="text-muted mb-0">Pilih hunian atau investasi terbaru dari OMNIHOUSE.</p>
            </div>
            <a href="/search" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="row g-4">
            <?php foreach ($properties as $property): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <img src="<?= esc(imageUrl($property['image'] ?? propertyPlaceholder())) ?>" class="card-img-top" alt="Properti" loading="lazy" style="height: 220px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-primary-subtle text-primary mb-2 text-uppercase"><?= esc($property['type']) ?></span>
                            <h5 class="card-title fw-semibold mb-1"><?= esc($property['title']) ?></h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> <?= esc($property['city']) ?></p>
                            <p class="fw-bold text-success mb-3"><?= formatRupiah($property['price']) ?></p>
                            <a href="/properti/<?= $property['id'] ?>" class="btn btn-outline-dark btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.hero-section {
    min-height: 720px;
    background: linear-gradient(135deg, rgba(10, 84, 168, .95) 0%, rgba(6, 91, 152, .95) 100%);
}
.hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80');
    background-size: cover;
    background-position: center;
    filter: brightness(0.5);
    z-index: 1;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(5, 50, 110, 0.55);
    z-index: 2;
}
.hero-section .container {
    position: relative;
    z-index: 3;
}
.icon-box {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.hover-shadow:hover {
    transform: translateY(-4px);
    transition: transform 0.2s ease;
}
.promo-card {
    min-height: 145px;
}
</style>
<?= $this->endSection() ?>
''