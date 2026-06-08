<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'subscription_status',
        'upload_count',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role'     => 'permit_empty|in_list[buyer,seller,admin]',
        'subscription_status' => 'permit_empty|in_list[free,basic,premium]',
        'upload_count' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah terdaftar.',
        ],
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)
            ->where('deleted_at', null)
            ->first();
    }

    public function getSellerProfile(int $id): ?array
    {
        return $this->select('users.*')
            ->where('users.id', $id)
            ->where('users.role', 'seller')
            ->where('users.deleted_at', null)
            ->first();
    }
}
