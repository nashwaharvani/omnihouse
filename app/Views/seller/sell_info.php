<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-primary mb-3">Iklankan Properti</span>
                <h1 class="display-5 fw-bold">Pasang Listing Properti Anda dengan Mudah</h1>
                <p class="lead text-white-75">OMNIHOUSE membantu Anda menjangkau pembeli dan penyewa dengan cepat melalui tampilan profesional dan formulir yang sederhana.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <?php if ($user): ?>
                        <a href="<?= site_url('seller/properti/tambah') ?>" class="btn btn-light btn-lg">Mulai Pasang Iklan</a>
                        <a href="<?= site_url('my-properties') ?>" class="btn btn-outline-light btn-lg">Kelola Properti Saya</a>
                    <?php else: ?>
                        <a href="<?= site_url('login/seller') . '?next=' . urlencode('/seller/properti/tambah') ?>" class="btn btn-light btn-lg">Masuk sebagai Penjual</a>
                        <a href="<?= site_url('register/seller') ?>" class="btn btn-outline-light btn-lg">Daftar Penjual</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card rounded-4 shadow-lg border-0 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1600573473090-89abbe731bd4?auto=format&fit=crop&w=1200&q=80" class="img-fluid" alt="Iklan Properti">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Kontrol Penuh</h5>
                    <p class="text-muted mb-0">Atur status jual atau sewa, harga, dan detail listing kapan saja.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Upload Foto</h5>
                    <p class="text-muted mb-0">Unggah gambar properti dengan mudah dan tampilkan foto terbaik.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Deskripsi Lengkap</h5>
                    <p class="text-muted mb-0">Lengkapi informasi lokasi, fasilitas, dan kontak agar calon pembeli cepat tertarik.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-semibold">Tampilkan di Marketplace</h5>
                    <p class="text-muted mb-0">Listing Anda akan tampil di halaman utama dan hasil pencarian.</p>
                </div>
            </div>
        </div>

        <div class="row align-items-center mt-5 gy-4">
            <div class="col-lg-6">
                <div class="card rounded-4 shadow-sm p-4 h-100 border-top border-primary border-4">
                    <h4 class="fw-bold mb-3">Kenapa Pilih OMNIHOUSE?</h4>
                    <ul class="list-unstyled text-muted mb-0">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Platform marketplace properti yang mudah diakses.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Dukungan untuk jual dan sewa properti.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Kontak penjual langsung tanpa biaya tersembunyi.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card rounded-4 shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-3">Layanan Tambahan</h4>
                    <p class="text-muted">Masih butuh lebih? Tingkatkan fitur dengan paket langganan untuk lebih banyak upload dan promosi.</p>
                    <a href="<?= site_url('langganan') ?>" class="btn btn-primary">Lihat Paket Langganan</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
