<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTerjualStatusToProperties extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('properties', [
            'status' => [
                'name'       => 'status',
                'type'       => 'ENUM',
                'constraint' => ['dijual', 'disewa', 'dipesan', 'terjual'],
                'default'    => 'dijual',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('properties', [
            'status' => [
                'name'       => 'status',
                'type'       => 'ENUM',
                'constraint' => ['dijual', 'disewa', 'dipesan'],
                'default'    => 'dijual',
            ],
        ]);
    }
}

