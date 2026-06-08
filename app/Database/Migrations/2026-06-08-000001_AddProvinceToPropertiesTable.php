<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvinceToPropertiesTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('province', 'properties')) {
            $fields = [
                'province' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
            ];

            $this->forge->addColumn('properties', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('province', 'properties')) {
            $this->forge->dropColumn('properties', 'province');
        }
    }
}
