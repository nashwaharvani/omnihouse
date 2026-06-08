<?php $title = 'Cari Properti - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$heroImages = [
    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80',
    'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1400&q=80',
    'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1400&q=80'
];
$heroImage = $heroImages[array_rand($heroImages)];
?>

<section class="position-relative overflow-hidden" style="min-height: 560px;">
    <div class="search-hero-background position-absolute top-0 start-0 w-100 h-100" style="background-image: linear-gradient(rgba(15,23,42,0.35), rgba(15,23,42,0.35)), url('<?= esc($heroImage) ?>'); background-size: cover; background-position: center; filter: saturate(1.05);"></div>
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(8, 26, 56, 0.32);"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <div class="rounded-4 p-4 p-md-5 text-white" style="backdrop-filter: blur(8px); background: rgba(10, 25, 58, 0.35);">
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-3">Cari Properti</span>
                    <h1 class="display-5 fw-bold mb-3">Temukan properti favoritmu dengan cepat</h1>
                    <p class="lead text-white-75 mb-4">Ketik nama properti, daerah, atau tipe hunian, lalu biarkan sistem menampilkan pilihan paling relevan.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2">Dijual</span>
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2">Disewa</span>
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2">Solo</span>
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2">Apartemen</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card rounded-4 shadow-lg p-4 p-md-5 border-0">
                    <div class="mb-4">
                        <p class="text-muted small mb-2">Masukkan kata kunci pencarian</p>
                        <h2 class="h4 fw-bold mb-0">Mulai Cari Properti</h2>
                    </div>
                    <form id="search-filter-form" method="get" action="<?= site_url('search') ?>">
                        <div class="mb-3">
                            <div class="input-group input-group-lg rounded-pill overflow-hidden border border-2 border-primary">
                                <span class="input-group-text bg-white text-primary border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="keyword" class="form-control border-0" placeholder="Solo, Apartemen, Perumahan" value="<?= esc($keyword ?? '') ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <select name="status" class="form-select form-select-lg rounded-pill">
                                    <option value="">Semua Status</option>
                                    <option value="dijual" <?= (($filters['status'] ?? '') === 'dijual') ? 'selected' : '' ?>>Dijual</option>
                                    <option value="disewa" <?= (($filters['status'] ?? '') === 'disewa') ? 'selected' : '' ?>>Disewa</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="type" class="form-select form-select-lg rounded-pill">
                                    <option value="">Semua Tipe</option>
                                    <option value="rumah" <?= (($filters['type'] ?? '') === 'rumah') ? 'selected' : '' ?>>Rumah</option>
                                    <option value="apartemen" <?= (($filters['type'] ?? '') === 'apartemen') ? 'selected' : '' ?>>Apartemen</option>
                                    <option value="kontrakan" <?= (($filters['type'] ?? '') === 'kontrakan') ? 'selected' : '' ?>>Kontrakan</option>
                                    <option value="kost" <?= (($filters['type'] ?? '') === 'kost') ? 'selected' : '' ?>>Kost</option>
                                    <option value="ruko" <?= (($filters['type'] ?? '') === 'ruko') ? 'selected' : '' ?>>Ruko</option>
                                    <option value="tanah" <?= (($filters['type'] ?? '') === 'tanah') ? 'selected' : '' ?>>Tanah</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <input type="text" name="city" class="form-control form-control-lg rounded-pill" placeholder="Kota atau daerah" value="<?= esc($filters['city'] ?? '') ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" name="price_max" class="form-control form-control-lg rounded-pill" placeholder="Harga max" value="<?= esc($filters['max_price'] ?? '') ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">Cari Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        <aside class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 1rem;">
                <h5 class="fw-semibold mb-3">Filter Tambahan</h5>
                <form method="get" action="<?= site_url('search') ?>">
                    <input type="hidden" name="keyword" value="<?= esc($keyword ?? '') ?>">
                    <div class="mb-3">
                        <label class="form-label">Kota atau Daerah</label>
                        <input type="text" name="city" class="form-control" placeholder="Jakarta, Solo" value="<?= esc($filters['city'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Max</label>
                        <input type="number" name="price_max" class="form-control" placeholder="1.000.000.000" value="<?= esc($filters['max_price'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Properti</label>
                        <select name="type" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="rumah" <?= (($filters['type'] ?? '') === 'rumah') ? 'selected' : '' ?>>Rumah</option>
                            <option value="apartemen" <?= (($filters['type'] ?? '') === 'apartemen') ? 'selected' : '' ?>>Apartemen</option>
                            <option value="kontrakan" <?= (($filters['type'] ?? '') === 'kontrakan') ? 'selected' : '' ?>>Kontrakan</option>
                            <option value="kost" <?= (($filters['type'] ?? '') === 'kost') ? 'selected' : '' ?>>Kost</option>
                            <option value="ruko" <?= (($filters['type'] ?? '') === 'ruko') ? 'selected' : '' ?>>Ruko</option>
                            <option value="tanah" <?= (($filters['type'] ?? '') === 'tanah') ? 'selected' : '' ?>>Tanah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="dijual" <?= (($filters['status'] ?? '') === 'dijual') ? 'selected' : '' ?>>Dijual</option>
                            <option value="disewa" <?= (($filters['status'] ?? '') === 'disewa') ? 'selected' : '' ?>>Disewa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">Terapkan Filter</button>
                </form>
            </div>
        </aside>

        <main class="col-xl-8">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1">Hasil Pencarian</h2>
                    <p class="text-muted mb-0">Menampilkan <?= $total ?? 0 ?> properti<?= !empty($keyword) ? ' untuk "' . esc($keyword) . '"' : '' ?></p>
                </div>
                <div class="text-muted">Jika tidak ketemu, coba ganti kata kunci atau hapus filter.</div>
            </div>

            <?php if (empty($properties)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <h5 class="fw-semibold mb-3">Properti tidak tersedia</h5>
                    <p class="text-muted mb-3">Maaf, tidak ada hasil untuk pencarianmu.</p>
                    <p class="small text-muted">Coba kata kunci lain seperti nama daerah, tipe properti, atau nama perumahan.</p>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php foreach ($properties as $property): ?>
                        <div class="col">
                            <?= $this->include('components/property-card', ['property' => $property]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    <?= $pager ?? '' ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hero = document.querySelector('.search-hero-background');
        const images = [
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1400&q=80'
        ];
        let currentIndex = 0;
        if (hero) {
            setInterval(function () {
                currentIndex = (currentIndex + 1) % images.length;
                hero.style.backgroundImage = 'linear-gradient(rgba(15,23,42,0.35), rgba(15,23,42,0.35)), url(' + images[currentIndex] + ')';
            }, 7000);
        }
    });
</script>

<?= $this->endSection() ?>
