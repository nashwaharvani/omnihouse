<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'title',
        'message',
        'type',
        'is_read',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGeneralNotifications(int $limit = 6): array
    {
        return $this->whereIn('type', ['promo', 'property', 'system'])
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    public function getPersonalNotificationsForUser(int $userId, int $limit = 6): array
    {
        return $this->builder()
            ->select('notifications.*, user_notifications.is_read as user_is_read, user_notifications.is_deleted')
            ->join('user_notifications', 'user_notifications.notification_id = notifications.id AND user_notifications.user_id = ' . (int) $userId, 'inner')
            ->where('notifications.type', 'personal')
            ->where('user_notifications.is_deleted', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getLatestVisibleNotificationsForUser(?int $userId = null, int $limit = 6): array
    {
        $generalBuilder = $this->builder()
            ->select('notifications.*');

        if ($userId) {
            $generalBuilder->select('COALESCE(user_notifications.is_read, 0) as user_is_read, COALESCE(user_notifications.is_deleted, 0) as user_is_deleted')
                ->join('user_notifications', 'user_notifications.notification_id = notifications.id AND user_notifications.user_id = ' . (int) $userId, 'left');
        } else {
            $generalBuilder->select('0 as user_is_read, 0 as user_is_deleted');
        }

        $generalBuilder->whereIn('notifications.type', ['promo', 'property', 'system']);

        if ($userId) {
            $generalBuilder->groupStart()
                ->where('user_notifications.is_deleted', 0)
                ->orWhere('user_notifications.is_deleted', null)
            ->groupEnd();
        }

        $general = $generalBuilder
            ->orderBy('notifications.created_at', 'DESC')
            ->get()
            ->getResultArray();

        if (!$userId) {
            return array_slice($general, 0, $limit);
        }

        $personal = $this->builder()
            ->select('notifications.*, user_notifications.is_read as user_is_read, user_notifications.is_deleted')
            ->join('user_notifications', 'user_notifications.notification_id = notifications.id', 'inner')
            ->where('notifications.type', 'personal')
            ->where('user_notifications.user_id', $userId)
            ->where('user_notifications.is_deleted', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $all = array_merge($general, $personal);
        usort($all, static function ($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });

        return array_slice($all, 0, $limit);
    }

    public function countGeneralUnread(?int $userId = null): int
    {
        if (!$userId) {
            return $this->whereIn('type', ['promo', 'property', 'system'])
                ->where('is_read', 0)
                ->countAllResults();
        }

        $builder = $this->builder()
            ->select('notifications.id')
            ->join('user_notifications', 'user_notifications.notification_id = notifications.id AND user_notifications.user_id = ' . (int) $userId, 'left')
            ->whereIn('notifications.type', ['promo', 'property', 'system'])
            ->groupStart()
                ->where('notifications.is_read', 0)
                ->where('user_notifications.is_read', null)
            ->groupEnd()
            ->orGroupStart()
                ->where('notifications.is_read', 0)
                ->where('user_notifications.is_read', 0)
                ->where('user_notifications.is_deleted', 0)
            ->groupEnd();

        return $builder->countAllResults();
    }
}
