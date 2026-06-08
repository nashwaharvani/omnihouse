<?php
/**
 * @var array  $filters
 * @var string $keyword
 * @var array  $propertyTypes
 * @var array  $cities
 * @var string $formId
 */
$provinces = [
    'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Banten',
    'Bali', 'Sumatera Utara', 'DI Yogyakarta', 'Sulawesi Selatan',
];
?>
<div class="search-filter-card">
    <form method="get" action="<?= site_url('search') ?>" id="<?= esc($formId) ?>">
        <input type="hidden" name="keyword" value="<?= esc($keyword) ?>">
        <input type="hidden" name="sort" value="<?= esc($filters['sort'] ?? 'newest') ?>">

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Status</h6>
            <div class="filter-pill-group" data-filter-group>
                <input type="hidden" name="status" value="<?= esc($filters['status'] ?? '') ?>">
                <?php
                $statuses = ['' => 'Semua', 'dijual' => 'Dijual', 'disewa' => 'Disewa'];
                foreach ($statuses as $val => $label): ?>
                    <button type="button" class="filter-pill <?= ($filters['status'] ?? '') === $val ? 'is-active' : '' ?>"
                            data-value="<?= esc($val) ?>"><?= esc($label) ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Lokasi</h6>
            <label class="form-label small text-muted" for="<?= esc($formId) ?>-city">Kota / Area</label>
            <input type="text" name="city" id="<?= esc($formId) ?>-city" class="form-control"
                   list="<?= esc($formId) ?>-city-list" placeholder="Jakarta, Bandung, Solo..."
                   value="<?= esc($filters['city'] ?? '') ?>">
            <datalist id="<?= esc($formId) ?>-city-list">
                <?php foreach ($cities as $city): ?>
                    <option value="<?= esc($city) ?>">
                <?php endforeach; ?>
            </datalist>
            <label class="form-label small text-muted mt-2" for="<?= esc($formId) ?>-province">Provinsi</label>
            <select name="province" id="<?= esc($formId) ?>-province" class="form-select">
                <option value="">Semua Provinsi</option>
                <?php foreach ($provinces as $province): ?>
                    <option value="<?= esc($province) ?>" <?= ($filters['province'] ?? '') === $province ? 'selected' : '' ?>>
                        <?= esc($province) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Tipe Properti</h6>
            <div class="filter-pill-group filter-pill-group--wrap" data-filter-group>
                <input type="hidden" name="type" value="<?= esc($filters['type'] ?? '') ?>">
                <button type="button" class="filter-pill <?= empty($filters['type']) ? 'is-active' : '' ?>" data-value="">Semua</button>
                <?php foreach ($propertyTypes as $val => $label): ?>
                    <button type="button" class="filter-pill <?= ($filters['type'] ?? '') === $val ? 'is-active' : '' ?>"
                            data-value="<?= esc($val) ?>"><?= esc($label) ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Rentang Harga</h6>
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <input type="number" name="price_min" class="form-control form-control-sm"
                           placeholder="Min" value="<?= esc($filters['min_price'] ?? '') ?>">
                </div>
                <div class="col-6">
                    <input type="number" name="price_max" class="form-control form-control-sm"
                           placeholder="Max" value="<?= esc($filters['max_price'] ?? '') ?>">
                </div>
            </div>
            <div class="price-preset-group">
                <button type="button" class="price-preset" data-min="" data-max="500000000">&lt; 500 Jt</button>
                <button type="button" class="price-preset" data-min="500000000" data-max="1000000000">500 Jt – 1 M</button>
                <button type="button" class="price-preset" data-min="1000000000" data-max="2000000000">1 – 2 M</button>
                <button type="button" class="price-preset" data-min="2000000000" data-max="">&gt; 2 M</button>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Kamar Tidur</h6>
            <div class="filter-pill-group" data-filter-group>
                <input type="hidden" name="bedrooms" value="<?= esc($filters['bedrooms'] ?? '') ?>">
                <button type="button" class="filter-pill <?= empty($filters['bedrooms']) ? 'is-active' : '' ?>" data-value="">Semua</button>
                <?php foreach ([1, 2, 3, 4] as $n): ?>
                    <button type="button" class="filter-pill <?= ($filters['bedrooms'] ?? '') == $n ? 'is-active' : '' ?>"
                            data-value="<?= $n ?>"><?= $n ?>+</button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Kamar Mandi</h6>
            <div class="filter-pill-group" data-filter-group>
                <input type="hidden" name="bathrooms" value="<?= esc($filters['bathrooms'] ?? '') ?>">
                <button type="button" class="filter-pill <?= empty($filters['bathrooms']) ? 'is-active' : '' ?>" data-value="">Semua</button>
                <?php foreach ([1, 2, 3] as $n): ?>
                    <button type="button" class="filter-pill <?= ($filters['bathrooms'] ?? '') == $n ? 'is-active' : '' ?>"
                            data-value="<?= $n ?>"><?= $n ?>+</button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Luas Tanah (m²)</h6>
            <div class="row g-2">
                <div class="col-6">
                    <input type="number" name="land_min" class="form-control form-control-sm"
                           placeholder="Min" value="<?= esc($filters['min_land_area'] ?? '') ?>">
                </div>
                <div class="col-6">
                    <input type="number" name="land_max" class="form-control form-control-sm"
                           placeholder="Max" value="<?= esc($filters['max_land_area'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="search-filter-section">
            <h6 class="search-filter-heading">Luas Bangunan (m²)</h6>
            <div class="row g-2">
                <div class="col-6">
                    <input type="number" name="building_min" class="form-control form-control-sm"
                           placeholder="Min" value="<?= esc($filters['min_building_area'] ?? '') ?>">
                </div>
                <div class="col-6">
                    <input type="number" name="building_max" class="form-control form-control-sm"
                           placeholder="Max" value="<?= esc($filters['max_building_area'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="search-filter-actions">
            <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
            <a href="<?= site_url('search') ?>" class="btn btn-outline-primary w-100 mt-2">Reset Filter</a>
        </div>
    </form>
</div>
