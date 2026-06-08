<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDipesanStatusToProperties extends Migration
{
    public function up()
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

    public function down()
    {
        $this->forge->modifyColumn('properties', [
            'status' => [
                'name'       => 'status',
                'type'       => 'ENUM',
                'constraint' => ['dijual', 'disewa'],
                'default'    => 'dijual',
            ],
        ]);
    }
}

