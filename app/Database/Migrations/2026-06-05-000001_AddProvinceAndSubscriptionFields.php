<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvinceAndSubscriptionFields extends Migration
{
    public function up()
    {
        // Add province to properties
        if (! $this->db->fieldExists('province', 'properties')) {
            $fields = [
                'province' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
            ];
            $this->forge->addColumn('properties', $fields);
        }

        // Add subscription_status and upload_count to users
        if (! $this->db->fieldExists('subscription_status', 'users')) {
            $fields = [
                'subscription_status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['free', 'basic', 'premium'],
                    'default'    => 'free',
                ],
            ];
            $this->forge->addColumn('users', $fields);
        }

        if (! $this->db->fieldExists('upload_count', 'users')) {
            $fields = [
                'upload_count' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
            ];
            $this->forge->addColumn('users', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('province', 'properties')) {
            $this->forge->dropColumn('properties', 'province');
        }

        if ($this->db->fieldExists('subscription_status', 'users')) {
            $this->forge->dropColumn('users', 'subscription_status');
        }

        if ($this->db->fieldExists('upload_count', 'users')) {
            $this->forge->dropColumn('users', 'upload_count');
        }
    }
}
