<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyImageModel extends Model
{
    protected $table            = 'property_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'property_id',
        'image_path',
        'is_primary',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getPrimaryImage(int $propertyId): ?array
    {
        return $this->where('property_id', $propertyId)
            ->where('is_primary', 1)
            ->orderBy('id', 'ASC')
            ->first();
    }

    public function getByProperty(int $propertyId): array
    {
        return $this->where('property_id', $propertyId)
            ->orderBy('is_primary', 'DESC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
