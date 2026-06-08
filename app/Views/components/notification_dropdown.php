<?php

use App\Models\NotificationModel;
use App\Models\UserNotificationModel;

$notificationModel = new NotificationModel();
$userNotificationModel = new UserNotificationModel();
$userId = session()->get('user_id');
$notifications = $notificationModel->getLatestVisibleNotificationsForUser($userId, 6);
$generalUnread = $notificationModel->countGeneralUnread($userId);
$personalUnread = $userId ? $userNotificationModel->getUnreadCount($userId) : 0;
$totalUnread = $generalUnread + $personalUnread;

foreach ($notifications as &$note) {
    if (array_key_exists('user_is_read', $note)) {
        $note['is_read'] = (int) $note['user_is_read'];
    }
    if (!isset($note['is_read'])) {
        $note['is_read'] = (int) ($note['type'] === 'personal' ? 1 : $note['is_read']);
    }
    $note['category_label'] = match ($note['type']) {
        'promo' => 'Promo',
        'property' => 'Properti',
        'system' => 'Sistem',
        'personal' => 'Pribadi',
        default => 'Umum',
    };
}

unset($note);
?>
<style>
.dropdown-menu-notifications {
    min-width: 360px;
    max-width: 420px;
}
.dropdown-menu-notifications .notification-title {
    font-size: 0.95rem;
    font-weight: 600;
}
.dropdown-menu-notifications .notification-meta {
    font-size: 0.82rem;
}
.dropdown-menu-notifications .notification-item {
    transition: background-color .15s ease;
}
.dropdown-menu-notifications .notification-item.unread {
    background-color: #f8f9fa;
}
.dropdown-menu-notifications .notification-actions button {
    font-size: 0.78rem;
    padding: 0.3rem 0.45rem;
}
</style>
<li class="nav-item dropdown ms-2">
    <a class="nav-link position-relative text-white" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell-fill fs-5"></i>
        <?php if ($totalUnread > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= esc($totalUnread) ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-notifications shadow p-0" aria-labelledby="notificationDropdown" data-bs-auto-close="outside">
        <li class="px-3 py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h6 class="mb-1">Notifikasi</h6>
                    <p class="mb-0 text-muted small"><?= $userId ? 'Notifikasi umum dan personal' : 'Notifikasi umum terbaru' ?></p>
                </div>
                <?php if ($userId): ?>
                    <div class="d-flex gap-1">
                        <form action="<?= site_url('notifications/mark-all-read') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Tandai semua dibaca</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </li>

        <?php if (empty($notifications)): ?>
            <li class="px-3 py-4 text-center text-muted">Belum ada notifikasi saat ini.</li>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <li class="px-3 py-3 border-bottom notification-item <?= $notification['is_read'] ? '' : 'unread' ?>">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="notification-title"><?= esc($notification['title']) ?></span>
                                <span class="badge bg-<?= $notification['is_read'] ? 'secondary' : 'danger' ?> text-uppercase small"><?= esc($notification['category_label']) ?></span>
                            </div>
                            <p class="mb-2 text-muted small"><?= esc($notification['message']) ?></p>
                        </div>
                        <?php if (!$notification['is_read']): ?>
                            <span class="badge bg-danger rounded-circle p-2" title="Belum dibaca"></span>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 notification-meta">
                        <span class="text-muted small"><?= date('d M Y H:i', strtotime($notification['created_at'])) ?></span>
                        <?php if ($userId): ?>
                            <div class="notification-actions d-flex gap-1">
                                <form action="<?= site_url('notifications/mark-read/' . $notification['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-primary" <?= $notification['is_read'] ? 'disabled' : '' ?>>Tandai dibaca</button>
                                </form>
                                <form action="<?= site_url('notifications/delete/' . $notification['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
            <li class="px-3 py-2 text-center">
                <a class="text-decoration-none small" href="<?= $userId ? site_url('user/dashboard') : site_url('login') ?>">Lihat semua notifikasi</a>
            </li>
        <?php endif; ?>
    </ul>
</li>
