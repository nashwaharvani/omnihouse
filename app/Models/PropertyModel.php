<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table            = 'properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'title',
        'description',
        'price',
        'type',
        'status',
        'city',
        'province',
        'address',
        'bedrooms',
        'bathrooms',
        'garage',
        'land_area',
        'building_area',
        'contact_name',
        'contact_email',
        'whatsapp_number',
        'amenities',
        'is_active',
        'views',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'user_id'         => 'required|integer',
        'title'           => 'required|min_length[3]|max_length[150]',
        'price'           => 'required|numeric',
        'type'            => 'required|in_list[rumah,kontrakan,apartemen,kost,ruko,tanah]',
        'status'          => 'permit_empty|in_list[dijual,disewa]',
        'city'            => 'required|min_length[2]|max_length[100]',
        'whatsapp_number' => 'required|max_length[20]',
    ];

    public function getWithImages(int $id): ?array
    {
        return $this->select('properties.*, property_images.image_path')
            ->join('property_images', 'property_images.property_id = properties.id', 'left')
            ->where('properties.id', $id)
            ->where('properties.deleted_at', null)
            ->groupBy('properties.id')
            ->first();
    }

    public function getLatestProperties(int $limit = 8): array
    {
        return $this->select('properties.*, property_images.image_path as image')
            ->join('property_images', 'property_images.property_id = properties.id AND property_images.is_primary = 1', 'left')
            ->where('properties.deleted_at', null)
            ->where('properties.is_active', 1)
            ->orderBy('properties.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function searchProperties(string $keyword, array $filters = []): array
    {
        $builder = $this->select('properties.*, property_images.image_path as image')
            ->join('property_images', 'property_images.property_id = properties.id AND property_images.is_primary = 1', 'left')
            ->where('properties.deleted_at', null)
            ->where('properties.is_active', 1);

        if (trim($keyword) !== '') {
            $builder->groupStart()
                ->like('properties.title', $keyword)
                ->orLike('properties.description', $keyword)
                ->orLike('properties.city', $keyword)
                ->orLike('properties.province', $keyword)
                ->orLike('properties.address', $keyword)
            ->groupEnd();
        }

        if (!empty($filters['city'] ?? null)) {
            $builder->groupStart()
                ->like('properties.city', $filters['city'])
                ->orLike('properties.province', $filters['city'])
                ->orLike('properties.address', $filters['city'])
            ->groupEnd();
        }

        if (!empty($filters['min_price'] ?? null)) {
            $builder->where('properties.price >=', (float) $filters['min_price']);
        }

        if (!empty($filters['max_price'] ?? null)) {
            $builder->where('properties.price <=', (float) $filters['max_price']);
        }

        if (!empty($filters['type'] ?? null)) {
            $builder->where('properties.type', $filters['type']);
        }

        if (!empty($filters['status'] ?? null)) {
            $builder->where('properties.status', $filters['status']);
        }

        if (!empty($filters['bedrooms'] ?? null)) {
            $builder->where('properties.bedrooms >=', (int) $filters['bedrooms']);
        }

        if (!empty($filters['bathrooms'] ?? null)) {
            $builder->where('properties.bathrooms >=', (int) $filters['bathrooms']);
        }

        if (!empty($filters['province'] ?? null)) {
            $builder->like('properties.province', $filters['province']);
        }

        if (!empty($filters['min_land_area'] ?? null)) {
            $builder->where('properties.land_area >=', (int) $filters['min_land_area']);
        }

        if (!empty($filters['max_land_area'] ?? null)) {
            $builder->where('properties.land_area <=', (int) $filters['max_land_area']);
        }

        if (!empty($filters['min_building_area'] ?? null)) {
            $builder->where('properties.building_area >=', (int) $filters['min_building_area']);
        }

        if (!empty($filters['max_building_area'] ?? null)) {
            $builder->where('properties.building_area <=', (int) $filters['max_building_area']);
        }

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'price_asc'  => $builder->orderBy('properties.price', 'ASC'),
            'price_desc' => $builder->orderBy('properties.price', 'DESC'),
            'views'      => $builder->orderBy('properties.views', 'DESC'),
            default      => $builder->orderBy('properties.created_at', 'DESC'),
        };

        return $builder->findAll();
    }

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->where('deleted_at', null)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getAllActiveProperties(): array
    {
        return $this->select('properties.*, property_images.image_path as image')
            ->join('property_images', 'property_images.property_id = properties.id AND property_images.is_primary = 1', 'left')
            ->where('properties.deleted_at', null)
            ->where('properties.is_active', 1)
            ->orderBy('properties.created_at', 'DESC')
            ->findAll();
    }

    public function incrementView(int $id): bool
    {
        return (bool) $this->set('views', 'views + 1', false)
            ->where('id', $id)
            ->update();
    }
}
