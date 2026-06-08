<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'price' => [
                'type' => 'BIGINT',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['rumah', 'kontrakan', 'apartemen', 'kost', 'ruko', 'tanah'],
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['dijual', 'disewa'],
                'default'    => 'dijual',
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'bedrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'bathrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'land_area' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'building_area' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'whatsapp_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'is_active' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'views' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('properties', true);
    }

    public function down()
    {
        $this->forge->dropTable('properties', true);
    }
}
