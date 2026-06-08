<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\UserNotificationModel;

class NotificationsController extends BaseController
{
    protected NotificationModel $notificationModel;
    protected UserNotificationModel $userNotificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->userNotificationModel = new UserNotificationModel();
    }

    public function markRead(int $id)
    {
        $this->requireLogin();

        $notification = $this->notificationModel->find($id);
        if (!$notification) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
        }

        $this->userNotificationModel->markAsRead(session()->get('user_id'), $id);

        return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai dibaca.');
    }

    public function markAllRead()
    {
        $this->requireLogin();

        $this->userNotificationModel->markAllRead(session()->get('user_id'));

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }

    public function delete(int $id)
    {
        $this->requireLogin();

        $notification = $this->notificationModel->find($id);
        if (!$notification) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
        }

        $this->userNotificationModel->markAsDeleted(session()->get('user_id'), $id);

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
