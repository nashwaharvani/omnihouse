<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'property_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getConversation(int $propertyId, int $senderId, int $receiverId): array
    {
        return $this->select('messages.*, sender.name as sender_name, receiver.name as receiver_name')
            ->join('users as sender', 'sender.id = messages.sender_id', 'left')
            ->join('users as receiver', 'receiver.id = messages.receiver_id', 'left')
            ->where('messages.property_id', $propertyId)
            ->whereIn('messages.sender_id', [$senderId, $receiverId])
            ->whereIn('messages.receiver_id', [$senderId, $receiverId])
            ->orderBy('messages.created_at', 'ASC')
            ->findAll();
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->where('receiver_id', $userId)
            ->where('is_read', 0)
            ->countAllResults();
    }

    public function markAsRead(int $conversationId): bool
    {
        return (bool) $this->set('is_read', 1)
            ->where('id', $conversationId)
            ->update();
    }
}
