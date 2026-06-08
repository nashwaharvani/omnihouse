<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvinceToPropertiesTable extends Migration
{
    private function hasColumn(string $table, string $column): bool
    {
        $dbName = (string) ($this->db->database ?? '');
        if ($dbName === '') {
            return $this->db->fieldExists($column, $table);
        }

        $row = $this->db->query(
            'SELECT 1 AS ok FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1',
            [$dbName, $table, $column]
        )->getRowArray();

        return (bool) ($row['ok'] ?? false);
    }

    public function up()
    {
        if (! $this->hasColumn('properties', 'province')) {
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
        if ($this->hasColumn('properties', 'province')) {
            $this->forge->dropColumn('properties', 'province');
        }
    }
}
