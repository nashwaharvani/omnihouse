<?php
$title = 'Cari Properti - OMNIHOUSE';

$propertyTypes = [
    'rumah'      => 'Rumah',
    'apartemen'  => 'Apartemen',
    'kontrakan'  => 'Kontrakan',
    'kost'       => 'Kost',
    'ruko'       => 'Ruko',
    'tanah'      => 'Tanah',
];

$statusTabs = [
    ''        => 'Semua',
    'dijual'  => 'Dijual',
    'disewa'  => 'Disewa',
];

$sortOptions = [
    'newest'     => 'Terbaru',
    'price_asc'  => 'Harga Terendah',
    'price_desc' => 'Harga Tertinggi',
    'views'      => 'Paling Dilihat',
];

$activeStatus = $filters['status'] ?? '';
$activeSort   = $filters['sort'] ?? 'newest';

$activeChips = [];
if (!empty($keyword)) {
    $activeChips[] = ['label' => '"' . $keyword . '"', 'remove' => ['keyword' => '']];
}
if (!empty($filters['city'])) {
    $activeChips[] = ['label' => $filters['city'], 'remove' => ['city' => '']];
}
if (!empty($filters['province'])) {
    $activeChips[] = ['label' => $filters['province'], 'remove' => ['province' => '']];
}
if (!empty($filters['type'])) {
    $activeChips[] = ['label' => $propertyTypes[$filters['type']] ?? $filters['type'], 'remove' => ['type' => '']];
}
if (!empty($filters['status'])) {
    $activeChips[] = ['label' => ucfirst($filters['status']), 'remove' => ['status' => '']];
}
if (!empty($filters['min_price'])) {
    $activeChips[] = ['label' => 'Min ' . formatRupiah($filters['min_price']), 'remove' => ['price_min' => '']];
}
if (!empty($filters['max_price'])) {
    $activeChips[] = ['label' => 'Max ' . formatRupiah($filters['max_price']), 'remove' => ['price_max' => '']];
}
if (!empty($filters['bedrooms'])) {
    $activeChips[] = ['label' => $filters['bedrooms'] . '+ Kamar', 'remove' => ['bedrooms' => '']];
}
if (!empty($filters['bathrooms'])) {
    $activeChips[] = ['label' => $filters['bathrooms'] . '+ Kamar Mandi', 'remove' => ['bathrooms' => '']];
}

$buildQuery = static function (array $overrides = []) use ($keyword, $filters): string {
    $params = array_filter([
        'keyword'      => $keyword,
        'city'         => $filters['city'] ?? '',
        'province'     => $filters['province'] ?? '',
        'type'         => $filters['type'] ?? '',
        'status'       => $filters['status'] ?? '',
        'price_min'    => $filters['min_price'] ?? '',
        'price_max'    => $filters['max_price'] ?? '',
        'bedrooms'     => $filters['bedrooms'] ?? '',
        'bathrooms'    => $filters['bathrooms'] ?? '',
        'land_min'     => $filters['min_land_area'] ?? '',
        'land_max'     => $filters['max_land_area'] ?? '',
        'building_min' => $filters['min_building_area'] ?? '',
        'building_max' => $filters['max_building_area'] ?? '',
        'sort'         => $filters['sort'] ?? 'newest',
    ], static fn ($v) => $v !== '' && $v !== null);

    $params = array_merge($params, $overrides);

    foreach ($params as $key => $value) {
        if ($value === '' || $value === null) {
            unset($params[$key]);
        }
    }

    return site_url('search') . ($params ? '?' . http_build_query($params) : '');
};

$heroImages = [
    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80',
    'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1600&q=80',
    'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1600&q=80',
];
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="search-hero">
    <div class="search-hero__bg" style="background-image: url('<?= esc($heroImages[0]) ?>')"></div>
    <div class="search-hero__overlay"></div>
    <div class="container position-relative">
        <div class="search-hero__panel">
            <div class="search-hero__tabs" role="tablist">
                <?php foreach ($statusTabs as $value => $label): ?>
                    <a href="<?= esc($buildQuery(['status' => $value, 'page' => null])) ?>"
                       class="search-hero__tab <?= $activeStatus === $value ? 'is-active' : '' ?>">
                        <?= esc($label) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <form method="get" action="<?= site_url('search') ?>" class="search-hero__form" id="search-main-form">
                <input type="hidden" name="status" value="<?= esc($activeStatus) ?>">
                <input type="hidden" name="sort" value="<?= esc($activeSort) ?>">
                <div class="search-hero__input-wrap">
                    <i class="bi bi-search search-hero__icon"></i>
                    <input type="text" name="keyword" class="search-hero__input"
                           placeholder="Lokasi, keyword, area, project, developer"
                           value="<?= esc($keyword) ?>" autocomplete="off">
                    <button type="submit" class="search-hero__submit">Cari</button>
                </div>
            </form>
            <div class="search-hero__recent" id="recent-searches" hidden>
                <span class="search-hero__recent-label">Pencarian terakhir:</span>
                <div class="search-hero__recent-list" id="recent-searches-list"></div>
            </div>
        </div>
    </div>
</section>

<section class="search-body">
    <div class="container">
        <div class="search-toolbar d-lg-none">
            <button class="btn btn-outline-primary search-filter-toggle" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#searchFilterOffcanvas">
                <i class="bi bi-sliders me-2"></i>Filter
                <?php if (count($activeChips) > 0): ?>
                    <span class="badge bg-primary ms-1"><?= count($activeChips) ?></span>
                <?php endif; ?>
            </button>
            <form method="get" action="<?= site_url('search') ?>" class="search-toolbar__sort">
                <?php foreach (['keyword', 'city', 'province', 'type', 'status', 'price_min', 'price_max', 'bedrooms', 'bathrooms', 'land_min', 'land_max', 'building_min', 'building_max'] as $field):
                    $map = [
                        'price_min' => 'min_price', 'price_max' => 'max_price',
                        'land_min' => 'min_land_area', 'land_max' => 'max_land_area',
                        'building_min' => 'min_building_area', 'building_max' => 'max_building_area',
                    ];
                    $key = $map[$field] ?? $field;
                    $val = $field === 'keyword' ? $keyword : ($filters[$key] ?? '');
                    if ($val !== ''): ?>
                        <input type="hidden" name="<?= esc($field) ?>" value="<?= esc($val) ?>">
                    <?php endif;
                endforeach; ?>
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ($sortOptions as $value => $label): ?>
                        <option value="<?= esc($value) ?>" <?= $activeSort === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="row g-4">
            <aside class="col-lg-4 col-xl-3 d-none d-lg-block">
                <?= view('home/partials/search_filters', [
                    'filters'       => $filters,
                    'keyword'       => $keyword,
                    'propertyTypes' => $propertyTypes,
                    'cities'        => $cities,
                    'formId'        => 'search-sidebar-form',
                ]) ?>
            </aside>

            <main class="col-lg-8 col-xl-9">
                <div class="search-results-header">
                    <div>
                        <h1 class="search-results-title">Hasil Pencarian</h1>
                        <p class="search-results-count">
                            Menampilkan <strong><?= (int) ($total ?? 0) ?></strong> properti
                            <?php if (!empty($keyword)): ?>
                                untuk <em>"<?= esc($keyword) ?>"</em>
                            <?php endif; ?>
                        </p>
                    </div>
                    <form method="get" action="<?= site_url('search') ?>" class="search-sort-form d-none d-lg-block">
                        <?php foreach (['keyword', 'city', 'province', 'type', 'status', 'price_min', 'price_max', 'bedrooms', 'bathrooms', 'land_min', 'land_max', 'building_min', 'building_max'] as $field):
                            $map = [
                                'price_min' => 'min_price', 'price_max' => 'max_price',
                                'land_min' => 'min_land_area', 'land_max' => 'max_land_area',
                                'building_min' => 'min_building_area', 'building_max' => 'max_building_area',
                            ];
                            $key = $map[$field] ?? $field;
                            $val = $field === 'keyword' ? $keyword : ($filters[$key] ?? '');
                            if ($val !== ''): ?>
                                <input type="hidden" name="<?= esc($field) ?>" value="<?= esc($val) ?>">
                            <?php endif;
                        endforeach; ?>
                        <label class="search-sort-label" for="sort-desktop">Urutkan</label>
                        <select name="sort" id="sort-desktop" class="form-select form-select-sm" onchange="this.form.submit()">
                            <?php foreach ($sortOptions as $value => $label): ?>
                                <option value="<?= esc($value) ?>" <?= $activeSort === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <?php if (!empty($activeChips)): ?>
                    <div class="search-active-filters">
                        <?php foreach ($activeChips as $chip): ?>
                            <a href="<?= esc($buildQuery(array_merge($chip['remove'], ['page' => null]))) ?>" class="search-chip">
                                <?= esc($chip['label']) ?>
                                <i class="bi bi-x-lg"></i>
                            </a>
                        <?php endforeach; ?>
                        <a href="<?= site_url('search') ?>" class="search-chip search-chip--clear">Hapus Semua</a>
                    </div>
                <?php endif; ?>

                <?php if (empty($properties)): ?>
                    <div class="search-empty">
                        <div class="search-empty__icon"><i class="bi bi-house-x"></i></div>
                        <h2>Properti tidak ditemukan</h2>
                        <p>Maaf, tidak ada hasil yang cocok dengan kriteria pencarian Anda.</p>
                        <ul class="search-empty__tips">
                            <li>Coba kata kunci lain seperti nama kota atau tipe properti</li>
                            <li>Kurangi jumlah filter yang aktif</li>
                            <li>Perluas rentang harga atau luas bangunan</li>
                        </ul>
                        <a href="<?= site_url('search') ?>" class="btn btn-primary">Lihat Semua Properti</a>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        <?php foreach ($properties as $property): ?>
                            <div class="col">
                                <?= view('components/property-card', ['property' => $property]) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!empty($pager)): ?>
                        <div class="search-pagination"><?= $pager ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </main>
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-start search-filter-offcanvas" tabindex="-1" id="searchFilterOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Filter Pencarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <?= view('home/partials/search_filters', [
            'filters'       => $filters,
            'keyword'       => $keyword,
            'propertyTypes' => $propertyTypes,
            'cities'        => $cities,
            'formId'        => 'search-mobile-form',
        ]) ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const heroBg = document.querySelector('.search-hero__bg');
    const images = <?= json_encode($heroImages) ?>;
    let idx = 0;

    if (heroBg && images.length > 1) {
        setInterval(function () {
            idx = (idx + 1) % images.length;
            heroBg.style.backgroundImage = "url('" + images[idx] + "')";
        }, 8000);
    }

    const keywordInput = document.querySelector('.search-hero__input');
    const recentWrap = document.getElementById('recent-searches');
    const recentList = document.getElementById('recent-searches-list');
    const storageKey = 'omnihouse_recent_searches';

    function loadRecent() {
        try {
            return JSON.parse(localStorage.getItem(storageKey) || '[]');
        } catch (e) {
            return [];
        }
    }

    function saveRecent(term) {
        term = (term || '').trim();
        if (!term) return;
        let items = loadRecent().filter(function (t) { return t !== term; });
        items.unshift(term);
        items = items.slice(0, 5);
        localStorage.setItem(storageKey, JSON.stringify(items));
        renderRecent(items);
    }

    function renderRecent(items) {
        if (!recentWrap || !recentList) return;
        if (!items.length) {
            recentWrap.hidden = true;
            return;
        }
        recentWrap.hidden = false;
        recentList.innerHTML = items.map(function (term) {
            return '<button type="button" class="search-recent-chip" data-term="' + term.replace(/"/g, '&quot;') + '">' + term + '</button>';
        }).join('');
        recentList.querySelectorAll('.search-recent-chip').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (keywordInput) {
                    keywordInput.value = btn.dataset.term;
                    keywordInput.closest('form').submit();
                }
            });
        });
    }

    renderRecent(loadRecent());

    const mainForm = document.getElementById('search-main-form');
    if (mainForm && keywordInput) {
        mainForm.addEventListener('submit', function () {
            saveRecent(keywordInput.value);
        });
    }

    document.querySelectorAll('.filter-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            const group = pill.closest('[data-filter-group]');
            if (!group) return;
            group.querySelectorAll('.filter-pill').forEach(function (p) { p.classList.remove('is-active'); });
            pill.classList.add('is-active');
            const input = group.querySelector('input[type="hidden"]');
            if (input) input.value = pill.dataset.value || '';
        });
    });

    document.querySelectorAll('.price-preset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = btn.closest('form');
            if (!form) return;
            const min = form.querySelector('[name="price_min"]');
            const max = form.querySelector('[name="price_max"]');
            if (min) min.value = btn.dataset.min || '';
            if (max) max.value = btn.dataset.max || '';
            form.querySelectorAll('.price-preset').forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
        });
    });
});
</script>
<?= $this->endSection() ?>
