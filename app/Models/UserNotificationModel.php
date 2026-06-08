<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNotificationModel extends Model
{
    protected $table            = 'user_notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'notification_id',
        'is_read',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUnreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->where('is_deleted', 0)
            ->countAllResults();
    }

    public function markAsRead(int $userId, int $notificationId): bool
    {
        $existing = $this->where('user_id', $userId)
            ->where('notification_id', $notificationId)
            ->first();

        if ($existing) {
            return (bool) $this->update($existing['id'], [
                'is_read'    => 1,
                'is_deleted' => 0,
            ]);
        }

        return (bool) $this->insert([
            'user_id'         => $userId,
            'notification_id' => $notificationId,
            'is_read'         => 1,
            'is_deleted'      => 0,
        ]);
    }

    public function markAsDeleted(int $userId, int $notificationId): bool
    {
        $existing = $this->where('user_id', $userId)
            ->where('notification_id', $notificationId)
            ->first();

        if ($existing) {
            return (bool) $this->update($existing['id'], [
                'is_read'    => 1,
                'is_deleted' => 1,
            ]);
        }

        return (bool) $this->insert([
            'user_id'         => $userId,
            'notification_id' => $notificationId,
            'is_read'         => 1,
            'is_deleted'      => 1,
        ]);
    }

    public function markAllRead(int $userId): bool
    {
        $notificationModel = new NotificationModel();
        $generalNotifications = $notificationModel->whereIn('type', ['promo', 'property', 'system'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($generalNotifications as $notification) {
            $this->markAsRead($userId, $notification['id']);
        }

        return (bool) $this->set('is_read', 1)
            ->where('user_id', $userId)
            ->where('is_deleted', 0)
            ->update();
    }
}
