<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'property_id',
        'buyer_id',
        'seller_id',
        'payment_type',
        'payment_method',
        'amount',
        'status',
        'paid_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'property_id'   => 'required|integer',
        'buyer_id'      => 'required|integer',
        'seller_id'     => 'required|integer',
        'payment_type'  => 'required|in_list[dp,pelunasan]',
        'payment_method' => 'permit_empty|in_list[simulasi,transfer,cash,gateway]',
        'amount'        => 'required|numeric',
        'status'        => 'required|in_list[paid,pending,cancelled]',
    ];
}
