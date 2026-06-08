<?php
$title = 'OMNIHOUSE | Marketplace Properti';

$slides = [
    [
        'image'   => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=80',
        'badge'   => 'Properti Unggulan',
        'title'   => 'Hunian Modern di Jakarta Selatan',
        'price'   => 'Mulai dari Rp 1,2 Miliar',
        'cta'     => 'Lihat Properti',
        'ctaLink' => site_url('search?city=Jakarta&status=dijual'),
    ],
    [
        'image'   => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80',
        'badge'   => 'Best Deal',
        'title'   => 'Cluster Eksklusif BSD City',
        'price'   => 'Mulai dari Rp 850 Juta',
        'cta'     => 'Jelajahi Sekarang',
        'ctaLink' => site_url('search?city=Tangerang&type=rumah'),
    ],
    [
        'image'   => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1600&q=80',
        'badge'   => 'Investasi Properti',
        'title'   => 'Apartemen Premium Thamrin',
        'price'   => 'Mulai dari Rp 600 Juta-an',
        'cta'     => 'Cari Apartemen',
        'ctaLink' => site_url('search?type=apartemen&status=dijual'),
    ],
];

$quickLinks = [
    ['icon' => 'bi-search', 'color' => '#3b82f6', 'title' => 'Carikan Properti', 'link' => site_url('search')],
    ['icon' => 'bi-megaphone-fill', 'color' => '#f59e0b', 'title' => 'Iklankan Properti', 'link' => site_url('jual-properti')],
    ['icon' => 'bi-people-fill', 'color' => '#8b5cf6', 'title' => 'Cari Agen', 'link' => site_url('search')],
    ['icon' => 'bi-percent', 'color' => '#ef4444', 'title' => 'Properti Turun Harga', 'link' => site_url('turun-harga')],
    ['icon' => 'bi-calculator-fill', 'color' => '#10b981', 'title' => 'Kalkulator KPR', 'link' => site_url('kalkulator-harga')],
    ['icon' => 'bi-arrow-repeat', 'color' => '#06b6d4', 'title' => 'Pindah KPR', 'link' => site_url('kalkulator-harga')],
    ['icon' => 'bi-chat-dots-fill', 'color' => '#ec4899', 'title' => 'Tanya Forum', 'link' => site_url('forum-properti')],
    ['icon' => 'bi-grid-3x3-gap-fill', 'color' => '#64748b', 'title' => 'Lainnya', 'link' => site_url('layanan-lainnya')],
];

$statusTabs = [
    'dijual' => 'Dijual',
    'disewa' => 'Disewa',
    'baru'   => 'Properti Baru',
];
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="home-hero">
    <div id="homeCarousel" class="carousel slide home-carousel" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators home-carousel__indicators">
            <?php foreach ($slides as $i => $slide): ?>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="<?= $i ?>"
                        class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($slides as $i => $slide): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="home-carousel__slide" style="background-image: url('<?= esc($slide['image']) ?>')">
                        <div class="home-carousel__content">
                            <span class="home-carousel__badge"><?= esc($slide['badge']) ?></span>
                            <h2 class="home-carousel__title"><?= esc($slide['title']) ?></h2>
                            <p class="home-carousel__price"><?= esc($slide['price']) ?></p>
                            <a href="<?= esc($slide['ctaLink']) ?>" class="btn btn-light btn-sm rounded-pill px-4 fw-semibold">
                                <?= esc($slide['cta']) ?> <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="home-carousel__control home-carousel__control--prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="home-carousel__control home-carousel__control--next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="container home-search-wrap">
        <div class="home-search-panel">
            <div class="home-search-tabs" role="tablist">
                <?php foreach ($statusTabs as $key => $label): ?>
                    <button type="button"
                            class="home-search-tab <?= $key === 'dijual' ? 'is-active' : '' ?>"
                            data-status="<?= $key === 'baru' ? '' : esc($key) ?>"
                            data-sort="<?= $key === 'baru' ? 'newest' : '' ?>">
                        <?= esc($label) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <form action="<?= site_url('search') ?>" method="get" class="home-search-form" id="home-search-form">
                <input type="hidden" name="status" id="home-search-status" value="dijual">
                <input type="hidden" name="sort" id="home-search-sort" value="">
                <div class="home-search-input-wrap">
                    <i class="bi bi-search home-search-icon"></i>
                    <input type="text" name="keyword" id="home-search-keyword" class="home-search-input"
                           placeholder="Lokasi, keyword, area, project, developer" autocomplete="off">
                    <button type="submit" class="home-search-btn">Cari</button>
                </div>
            </form>

            <div class="home-search-recent" id="home-recent-searches" hidden>
                <span class="home-search-recent-label">Pencarian terakhir:</span>
                <div class="home-search-recent-list" id="home-recent-list"></div>
            </div>
        </div>
    </div>
</section>

<section class="home-quicklinks">
    <div class="container">
        <div class="home-quicklinks-grid">
            <?php foreach ($quickLinks as $link): ?>
                <a href="<?= esc($link['link']) ?>" class="home-quicklink">
                    <span class="home-quicklink__icon" style="--icon-color: <?= esc($link['color']) ?>">
                        <i class="bi <?= esc($link['icon']) ?>"></i>
                    </span>
                    <span class="home-quicklink__label"><?= esc($link['title']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-map-banner">
    <div class="container">
        <a href="<?= site_url('search?city=Jakarta') ?>" class="home-map-card">
            <div class="home-map-card__icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="home-map-card__body">
                <strong>Peta Harga Properti</strong>
                <span>Jelajahi properti di Jakarta lewat pencarian interaktif OMNIHOUSE</span>
            </div>
            <i class="bi bi-chevron-right home-map-card__arrow"></i>
        </a>
    </div>
</section>

<section class="home-properties">
    <div class="container">
        <div class="home-section-header">
            <div>
                <h2 class="home-section-title">Properti Terbaru</h2>
                <p class="home-section-subtitle">Pilihan hunian dan investasi terbaru dari OMNIHOUSE</p>
            </div>
            <a href="<?= site_url('search') ?>" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($properties as $property): ?>
                <div class="col">
                    <?= view('components/property-card', ['property' => $property]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-cities">
    <div class="container">
        <h2 class="home-section-title mb-3">Populer di Kota Besar</h2>
        <div class="home-cities-grid">
            <?php foreach ($cities as $city): ?>
                <a href="<?= site_url('search?city=' . urlencode($city)) ?>" class="home-city-chip">
                    <i class="bi bi-geo-alt"></i> <?= esc($city) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const storageKey = 'omnihouse_recent_searches';
    const form = document.getElementById('home-search-form');
    const keywordInput = document.getElementById('home-search-keyword');
    const statusInput = document.getElementById('home-search-status');
    const sortInput = document.getElementById('home-search-sort');
    const recentWrap = document.getElementById('home-recent-searches');
    const recentList = document.getElementById('home-recent-list');

    function loadRecent() {
        try { return JSON.parse(localStorage.getItem(storageKey) || '[]'); }
        catch (e) { return []; }
    }

    function saveRecent(term) {
        term = (term || '').trim();
        if (!term) return;
        let items = loadRecent().filter(function (t) { return t !== term; });
        items.unshift(term);
        localStorage.setItem(storageKey, JSON.stringify(items.slice(0, 5)));
        renderRecent(items.slice(0, 5));
    }

    function renderRecent(items) {
        if (!recentWrap || !recentList) return;
        if (!items.length) { recentWrap.hidden = true; return; }
        recentWrap.hidden = false;
        recentList.innerHTML = items.map(function (term) {
            return '<button type="button" class="home-recent-chip" data-term="' + term.replace(/"/g, '&quot;') + '">' + term + '</button>';
        }).join('');
        recentList.querySelectorAll('.home-recent-chip').forEach(function (btn) {
            btn.addEventListener('click', function () {
                keywordInput.value = btn.dataset.term;
                form.submit();
            });
        });
    }

    renderRecent(loadRecent());

    document.querySelectorAll('.home-search-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.home-search-tab').forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');
            if (statusInput) statusInput.value = tab.dataset.status || '';
            if (sortInput) sortInput.value = tab.dataset.sort || '';
        });
    });

    if (form) {
        form.addEventListener('submit', function () {
            saveRecent(keywordInput.value);
        });
    }
});
</script>
<?= $this->endSection() ?>
