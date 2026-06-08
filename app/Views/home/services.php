<?php $title = 'Lainnya - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-primary mb-3">Layanan Properti</span>
                <h1 class="display-5 fw-bold">Layanan Lengkap OMNIHOUSE</h1>
                <p class="lead text-white-75">Temukan fitur tambahan untuk membuat perjalanan jual beli properti Anda lebih lancar dan terencana.</p>
                <a href="<?= site_url('search') ?>" class="btn btn-light btn-lg mt-3">Cari Properti Sekarang</a>
            </div>
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden shadow-sm">
                    <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80" class="img-fluid" alt="Layanan Properti">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Layanan Iklan Properti</h5>
                    <p class="text-muted">Bantuan unggah, promosi properti, dan optimasi listing Anda di OMNIHOUSE.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Analisis Harga</h5>
                    <p class="text-muted">Masukan tips penentuan harga dan strategi penawaran untuk properti Anda.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Konsultasi KPR</h5>
                    <p class="text-muted">Rencana cicilan dan informasi suku bunga untuk pembeli rumah.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Forum Komunitas</h5>
                    <p class="text-muted">Diskusi jual beli, pengalaman transaksi, dan tips pasar properti.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Konten Panduan</h5>
                    <p class="text-muted">Panduan proses sertifikat, pajak, dan dokumen legal properti.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Dukungan Pelanggan</h5>
                    <p class="text-muted">Tim support siap membantu pertanyaan dan kendala properti Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
