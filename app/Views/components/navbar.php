<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-dark" href="<?= site_url('/') ?>">
            <i class="bi bi-house-door-fill fs-4"></i>
            <span>OMNIHOUSE</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                <?php $userRole = session()->get('role'); ?>
                <?php if ($userRole === 'seller' || $userRole === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('dashboard/seller') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('my-properties') ?>">Kelola Properti</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-sm btn-primary rounded-pill px-4" href="<?= site_url('seller/properti/tambah') ?>">Tambah Properti</a>
                    </li>
                <?php elseif ($userRole === 'buyer'): ?>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('search') ?>">Cari Properti</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('favorit') ?>">Favorit</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('forum-properti') ?>">Komunitas</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('/') ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('search') ?>">Cari Properti</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('jual-properti') ?>">Jual Properti</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary px-3" href="<?= site_url('langganan') ?>">Langganan</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <?php if (session()->get('user_id')): ?>
                    <?= $this->include('components/notification_dropdown') ?>
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span><?= esc(session()->get('name') ?? 'User') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="<?= site_url('user/profil') ?>">Profil</a></li>
                            <li>
                                <a class="dropdown-item position-relative" href="<?= site_url('user/inbox') ?>">
                                    Inbox
                                    <?php if (session()->get('unread_messages') ?? 0): ?>
                                        <span class="badge rounded-pill bg-danger ms-2"><?= (int) session()->get('unread_messages') ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">Keluar</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item me-2">
                        <a class="btn btn-sm btn-outline-primary rounded-pill px-4" href="<?= site_url('login/buyer') ?>">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary rounded-pill px-4" href="<?= site_url('register/buyer') ?>">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
