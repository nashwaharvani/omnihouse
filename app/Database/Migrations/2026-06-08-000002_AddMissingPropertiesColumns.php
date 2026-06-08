<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingPropertiesColumns extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('garage', 'properties')) {
            $fields['garage'] = [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ];
        }

        if (! $this->db->fieldExists('contact_name', 'properties')) {
            $fields['contact_name'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ];
        }

        if (! $this->db->fieldExists('contact_email', 'properties')) {
            $fields['contact_email'] = [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ];
        }

        if (! $this->db->fieldExists('amenities', 'properties')) {
            $fields['amenities'] = [
                'type' => 'TEXT',
                'null' => true,
            ];
        }

        if (! empty($fields)) {
            $this->forge->addColumn('properties', $fields);
        }
    }

    public function down()
    {
        $columns = [];

        if ($this->db->fieldExists('garage', 'properties')) {
            $columns[] = 'garage';
        }
        if ($this->db->fieldExists('contact_name', 'properties')) {
            $columns[] = 'contact_name';
        }
        if ($this->db->fieldExists('contact_email', 'properties')) {
            $columns[] = 'contact_email';
        }
        if ($this->db->fieldExists('amenities', 'properties')) {
            $columns[] = 'amenities';
        }

        if (! empty($columns)) {
            $this->forge->dropColumn('properties', $columns);
        }
    }
}
