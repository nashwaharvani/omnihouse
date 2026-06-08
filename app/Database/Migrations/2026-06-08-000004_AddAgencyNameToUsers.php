<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgencyNameToUsers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('agency_name', 'users')) {
            $fields = [
                'agency_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
            ];

            $this->forge->addColumn('users', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('agency_name', 'users')) {
            $this->forge->dropColumn('users', 'agency_name');
        }
    }
}
