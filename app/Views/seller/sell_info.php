<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-6 bg-primary text-white p-5 d-flex flex-column justify-content-center">
                            <h1 class="display-6 fw-bold">Jual Properti Anda di OMNIHOUSE</h1>
                            <p class="lead text-white-75">Mulai pasang iklan properti dengan cepat dan mudah. Lengkapi data properti, unggah foto, dan biarkan pembeli menemukan listing Anda.</p>
                            <div class="d-flex gap-2 mt-4">
                                <?php if ($user): ?>
                                    <a href="<?= site_url('seller/properti/tambah') ?>" class="btn btn-light btn-lg">Mulai Jual Properti</a>
                                    <a href="<?= site_url('my-properties') ?>" class="btn btn-outline-light btn-lg">Lihat Properti Saya</a>
                                <?php else: ?>
                                    <a href="<?= site_url('login') . '?next=' . urlencode('/seller/properti/tambah') ?>" class="btn btn-light btn-lg">Masuk sebagai Penjual</a>
                                    <a href="<?= site_url('register') . '?role=seller' ?>" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 p-4">
                            <div class="p-4">
                                <h3 class="fw-semibold">Apa yang bisa Anda lakukan?</h3>
                                <ul class="list-unstyled mt-3 mb-0">
                                    <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i> Tambah listing properti dalam beberapa menit.</li>
                                    <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i> Kelola status jual / sewa dari dashboard.</li>
                                    <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i> Unggah foto properti dan informasi lengkap.</li>
                                    <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i> Dapatkan lebih banyak calon pembeli langsung.</li>
                                </ul>
                                <div class="mt-4">
                                    <span class="badge bg-secondary">Gratis</span>
                                    <span class="text-muted ms-2">Kuota unggah 2 properti untuk pengguna gratis.</span>
                                </div>
                                <div class="mt-3">
                                    <a href="<?= site_url('langganan') ?>" class="text-decoration-none">Lihat paket langganan untuk unggah tanpa batas &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
