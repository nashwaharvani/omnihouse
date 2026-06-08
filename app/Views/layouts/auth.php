<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary mb-3" style="width:64px;height:64px;">
                                <i class="bi bi-house-door-fill fs-3"></i>
                            </div>
                            <h2 class="h4 fw-bold text-dark mb-1">OMNIHOUSE</h2>
                            <p class="text-muted mb-0">Akses akun Anda untuk melanjutkan</p>
                        </div>
                        <?= $this->renderSection('auth-content') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
