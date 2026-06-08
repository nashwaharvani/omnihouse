<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PropertyImagesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['property_id' => 1, 'image_path' => 'assets/images/property-1.jpg', 'is_primary' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['property_id' => 2, 'image_path' => 'assets/images/property-2.jpg', 'is_primary' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['property_id' => 3, 'image_path' => 'assets/images/property-3.jpg', 'is_primary' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['property_id' => 4, 'image_path' => 'assets/images/property-4.jpg', 'is_primary' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['property_id' => 5, 'image_path' => 'assets/images/property-5.jpg', 'is_primary' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('property_images')->insertBatch($data);
    }
}
