<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar py-2">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= site_url('/') ?>">
                <i class="bi bi-house-door-fill fs-4"></i>
                <span class="site-brand-text">OMNIHOUSE</span>
            </a>

            <div class="d-flex align-items-center gap-2 d-lg-none ms-auto">
                <a class="btn btn-sm btn-outline-light rounded-pill px-3" href="<?= site_url('jual-properti') ?>">Pasang Iklan</a>
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center site-nav-main">
                    <?php $userRole = session()->get('role'); ?>
                    <?php if ($userRole === 'seller' || $userRole === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard/seller') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('my-properties') ?>">Kelola Properti</a></li>
                    <?php else: ?>
                        <!-- <li class="nav-item"><a class="nav-link" href="<?= site_url('search?status=dijual') ?>">Dijual</a></li> -->
                        <!-- <li class="nav-item"><a class="nav-link" href="<?= site_url('search?status=disewa') ?>">Disewa</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('search') ?>">Properti Baru</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('turun-harga') ?>">Turun Harga</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('kalkulator-harga') ?>">KPR</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('layanan-lainnya') ?>">Lainnya</a></li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-lg-2">
                    <?php if (!($userRole === 'seller' || $userRole === 'admin')): ?>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link site-nav-secondary" href="<?= site_url('search') ?>">Carikan Properti</a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link site-nav-secondary" href="<?= site_url('forum-properti') ?>">Forum</a>
                        </li>
                    <?php endif; ?>

                    <?php if (session()->get('user_id')): ?>
                        <?= $this->include('components/notification_dropdown') ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5"></i>
                                <span><?= esc(session()->get('name') ?? 'Akun') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="<?= site_url('user/profil') ?>">Profil</a></li>
                                <?php if (!($userRole === 'seller' || $userRole === 'admin')): ?>
                                    <li><a class="dropdown-item" href="<?= site_url('user/pemesanan') ?>">Pemesanan</a></li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('user/inbox') ?>">
                                        Inbox
                                        <?php if (session()->get('unread_messages') ?? 0): ?>
                                            <span class="badge rounded-pill bg-danger ms-1"><?= (int) session()->get('unread_messages') ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">Keluar</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item d-none d-lg-block">
                            <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="<?= site_url('login/buyer') ?>">Masuk</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item d-none d-lg-block">
                        <a class="btn btn-light btn-sm rounded-pill px-4 fw-semibold text-primary" href="<?= site_url('jual-properti') ?>">Pasang Iklan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
