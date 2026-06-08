<?php $title = 'Tanya Forum - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5 bg-secondary text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-secondary mb-3">Forum Properti</span>
                <h1 class="display-5 fw-bold">Tanya Jawab Komunitas</h1>
                <p class="lead text-white-75">Bergabung dalam diskusi, temukan jawaban cepat, dan dapatkan insight properti dari komunitas OMNIHOUSE.</p>
                <a href="<?= site_url('register/buyer') ?>" class="btn btn-white btn-lg text-primary mt-3">Bergabung Sekarang</a>
            </div>
            <div class="col-lg-5">
                <div class="card rounded-4 shadow-sm p-4 bg-white text-dark">
                    <h4 class="fw-semibold mb-3">Topik Populer</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 p-3">Bagaimana membeli rumah pertama dengan anggaran terbatas?</li>
                        <li class="list-group-item border-0 p-3">Strategi negosiasi harga untuk properti bekas</li>
                        <li class="list-group-item border-0 p-3">Tips memilih lokasi investasi sewa jangka panjang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card rounded-4 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 fw-bold">Pertanyaan Terbaru</h2>
                            <p class="text-muted mb-0">Dapatkan jawaban dari penjual, pembeli, dan ahli properti.</p>
                        </div>
                        <a href="<?= site_url('register/buyer') ?>" class="btn btn-outline-primary">Gabung Forum</a>
                    </div>

                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action rounded-4 mb-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Apakah harga rumah ini masih bisa nego?</h5>
                                    <p class="small text-muted mb-1">Dijual di Jakarta Selatan · 12 jawaban · 3 jam lalu</p>
                                </div>
                                <span class="badge bg-primary">Diskusi</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action rounded-4 mb-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">KPR atau cash: mana lebih baik untuk investor?</h5>
                                    <p class="small text-muted mb-1">Investasi properti · 18 jawaban · 1 hari lalu</p>
                                </div>
                                <span class="badge bg-success">Panduan</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action rounded-4 mb-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Bagaimana memastikan dokumen properti aman?</h5>
                                    <p class="small text-muted mb-1">Legal & Dokumen · 9 jawaban · 2 hari lalu</p>
                                </div>
                                <span class="badge bg-warning text-dark">Tips</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4">
                    <h5 class="fw-semibold mb-3">Kenapa Bergabung?</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tanya langsung ke pengguna dan agen properti.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Dapatkan opini objektif sebelum beli.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Pelajari pengalaman transaksi nyata.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
