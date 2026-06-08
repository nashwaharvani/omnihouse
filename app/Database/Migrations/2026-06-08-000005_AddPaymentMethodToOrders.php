<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentMethodToOrders extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('orders')) {
            return;
        }

        $fields = [];

        if (! $this->db->fieldExists('payment_method', 'orders')) {
            $fields['payment_method'] = [
                'type'       => 'ENUM',
                'constraint' => ['simulasi', 'transfer', 'cash', 'gateway'],
                'default'    => 'simulasi',
                'after'      => 'payment_type',
            ];
        }

        if (! $this->db->fieldExists('paid_at', 'orders')) {
            $fields['paid_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status',
            ];
        }

        if (! empty($fields)) {
            $this->forge->addColumn('orders', $fields);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('orders')) {
            return;
        }

        $columns = [];
        if ($this->db->fieldExists('payment_method', 'orders')) {
            $columns[] = 'payment_method';
        }
        if ($this->db->fieldExists('paid_at', 'orders')) {
            $columns[] = 'paid_at';
        }

        if (! empty($columns)) {
            $this->forge->dropColumn('orders', $columns);
        }
    }
}

