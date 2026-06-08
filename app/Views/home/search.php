<?php $title = 'Cari Properti - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="bg-primary py-5 text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-primary mb-3">Cari Properti</span>
                <h1 class="display-6 fw-bold">Temukan rumah impian Anda dengan cepat</h1>
                <p class="lead text-white-75">Gunakan kata kunci, kota, alamat, tipe, harga, dan jumlah kamar tidur untuk mencari properti paling relevan.</p>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <form method="get" action="/search">
                        <div class="mb-3">
                            <label class="form-label">Cari Properti</label>
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Properti, kota, alamat" value="<?= esc($keyword ?? '') ?>">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                        <input type="hidden" name="city" value="<?= esc($filters['city'] ?? '') ?>">
                        <input type="hidden" name="type" value="<?= esc($filters['type'] ?? '') ?>">
                        <input type="hidden" name="status" value="<?= esc($filters['status'] ?? '') ?>">
                        <input type="hidden" name="price_min" value="<?= esc($filters['min_price'] ?? '') ?>">
                        <input type="hidden" name="price_max" value="<?= esc($filters['max_price'] ?? '') ?>">
                        <input type="hidden" name="bedrooms" value="<?= esc($filters['bedrooms'] ?? '') ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row gy-4">
        <aside class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 1rem;">
                <h5 class="fw-semibold mb-3">Filter Pencarian</h5>
                <form method="get" action="/search">
                    <div class="mb-3">
                        <label class="form-label">Keyword</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Properti, kota, alamat" value="<?= esc($keyword ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control" value="<?= esc($filters['city'] ?? '') ?>" placeholder="Jakarta, Bandung">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Harga Min</label>
                            <input type="number" name="price_min" class="form-control" value="<?= esc($filters['min_price'] ?? '') ?>" placeholder="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Harga Max</label>
                            <input type="number" name="price_max" class="form-control" value="<?= esc($filters['max_price'] ?? '') ?>" placeholder="0">
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <label class="form-label">Tipe</label>
                            <select name="type" class="form-select">
                                <option value="">Semua</option>
                                <option value="rumah" <?= (($filters['type'] ?? '') === 'rumah') ? 'selected' : '' ?>>Rumah</option>
                                <option value="apartemen" <?= (($filters['type'] ?? '') === 'apartemen') ? 'selected' : '' ?>>Apartemen</option>
                                <option value="kontrakan" <?= (($filters['type'] ?? '') === 'kontrakan') ? 'selected' : '' ?>>Kontrakan</option>
                                <option value="kost" <?= (($filters['type'] ?? '') === 'kost') ? 'selected' : '' ?>>Kost</option>
                                <option value="ruko" <?= (($filters['type'] ?? '') === 'ruko') ? 'selected' : '' ?>>Ruko</option>
                                <option value="tanah" <?= (($filters['type'] ?? '') === 'tanah') ? 'selected' : '' ?>>Tanah</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua</option>
                                <option value="dijual" <?= (($filters['status'] ?? '') === 'dijual') ? 'selected' : '' ?>>Dijual</option>
                                <option value="disewa" <?= (($filters['status'] ?? '') === 'disewa') ? 'selected' : '' ?>>Disewa</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Kamar Tidur</label>
                        <select name="bedrooms" class="form-select">
                            <option value="">Semua</option>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <option value="<?= $i ?>" <?= ((string) ($filters['bedrooms'] ?? '') === (string) $i) ? 'selected' : '' ?>><?= $i ?>+</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                </form>
            </div>
        </aside>

        <section class="col-xl-8">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1">Hasil Pencarian</h2>
                    <p class="text-muted mb-0">Menampilkan <?= $total ?? 0 ?> properti</p>
                </div>
                <div class="text-muted">Gunakan filter untuk menemukan properti yang paling sesuai.</div>
            </div>

            <?php if (empty($properties)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <h5 class="fw-semibold mb-2">Tidak ada properti yang ditemukan</h5>
                    <p class="text-muted mb-0">Ubah kata kunci atau filter pencarian untuk melihat hasil lain.</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($properties as $property): ?>
                        <div class="col-md-6">
                            <?= $this->include('components/property-card', ['property' => $property]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    <?= $pager ?? '' ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</section>
<?= $this->endSection() ?>
