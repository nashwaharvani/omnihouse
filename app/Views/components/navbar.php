<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= site_url('/') ?>">
            <i class="bi bi-house-door-fill"></i>
            <span>OMNIHOUSE</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('search') ?>">Cari Properti</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('jual-properti') ?>">Jual Properti</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('langganan') ?>">Langganan</a></li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?= $this->include('components/notification_dropdown') ?>
                <?php if (!session()->get('user_id')): ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>Akun</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('login') ?>">Masuk</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('register') ?>">Daftar</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span><?= esc(session()->get('name') ?? 'User') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('user/dashboard') ?>">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('user/profil') ?>">Profil</a></li>
                            <li>
                                <a class="dropdown-item position-relative" href="<?= site_url('user/inbox') ?>">
                                    Inbox
                                    <?php if (session()->get('unread_messages') ?? 0): ?>
                                        <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger"><?= (int) session()->get('unread_messages') ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item btn btn-sm btn-outline-danger text-start" href="<?= site_url('logout') ?>">
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
