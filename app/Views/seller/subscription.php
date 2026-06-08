<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 fw-bold">Paket Langganan OMNIHOUSE</h1>
                            <p class="text-muted">Pilih paket yang sesuai untuk mengunggah properti tanpa batas dan menikmati fitur tambahan.</p>
                        </div>
                        <?php if ($user): ?>
                            <span class="badge bg-success">Status: <?= esc($user['subscription_status'] ?? 'free') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h5 class="fw-semibold">Gratis</h5>
                                <p class="mb-3 text-muted">Cocok untuk penjual baru.</p>
                                <p><strong>Kuota:</strong> 2 listing</p>
                                <p><strong>Fitur:</strong> Pasang iklan, kelola properti, chat pembeli.</p>
                                <a href="<?= site_url('login/seller') ?>" class="btn btn-outline-primary mt-3">Gunakan Gratis</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-primary text-white">
                                <h5 class="fw-semibold">Premium</h5>
                                <p class="mb-3 text-white-75">Unggah properti tanpa batas dan dapatkan prioritas listing.</p>
                                <p><strong>Kuota:</strong> Tanpa batas</p>
                                <p><strong>Fitur:</strong> Semua fitur gratis + dukungan prioritas.</p>
                                <a href="#" class="btn btn-light mt-3">Daftar Sekarang</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h5 class="fw-semibold">Bisnis</h5>
                                <p class="mb-3 text-muted">Untuk agen properti dan tim penjualan.</p>
                                <p><strong>Kuota:</strong> Tanpa batas</p>
                                <p><strong>Fitur:</strong> Multi-akun, laporan, prioritas trafik.</p>
                                <a href="#" class="btn btn-outline-primary mt-3">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
