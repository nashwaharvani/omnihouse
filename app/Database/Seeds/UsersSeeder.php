<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Admin OMNIHOUSE',
                'email'      => 'admin@omnihouse.test',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'phone'      => '081234567890',
                'avatar'     => 'https://via.placeholder.com/150',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Seller Properti',
                'email'      => 'seller@omnihouse.test',
                'password'   => password_hash('seller123', PASSWORD_DEFAULT),
                'role'       => 'seller',
                'phone'      => '081298765432',
                'avatar'     => 'https://via.placeholder.com/150',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
