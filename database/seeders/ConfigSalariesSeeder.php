<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB từ namespace này

class ConfigSalariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('config_salaries')->insert([
            [
                'id' => 1,
                'created_at' => '2024-07-17 07:44:14',
                'updated_at' => '2024-07-17 07:44:16',
                'is_active' => 1,
                'name' => 'Lương cơ bản',
                'display_order' => 1,
                'type' => 1,
            ],
            [
                'id' => 2,
                'created_at' => '2024-07-17 08:03:02',
                'updated_at' => '2024-07-17 08:03:02',
                'is_active' => 1,
                'name' => 'Lương thử việc',
                'display_order' => 2,
                'type' => 1,
            ],
            [
                'id' => 3,
                'created_at' => '2024-07-17 08:11:27',
                'updated_at' => '2024-07-17 08:11:25',
                'is_active' => 1,
                'name' => 'Phục cấp trách nhiệm',
                'display_order' => 3,
                'type' => 1,
            ],
            [
                'id' => 4,
                'created_at' => '2024-07-17 08:11:28',
                'updated_at' => '2024-07-17 08:11:26',
                'is_active' => 1,
                'name' => 'Phụ cấp trách nhiệm thử việc',
                'display_order' => 4,
                'type' => 1,
            ],
            [
                'id' => 5,
                'created_at' => '2024-07-17 08:23:21',
                'updated_at' => '2024-07-17 08:23:22',
                'is_active' => 1,
                'name' => 'Lương tính BHXH',
                'display_order' => 5,
                'type' => 1,
            ],
            [
                'id' => 6,
                'created_at' => '2024-07-17 08:23:47',
                'updated_at' => '2024-07-17 08:23:48',
                'is_active' => 1,
                'name' => 'Phụ cấp xăng xe',
                'display_order' => 6,
                'type' => 2,
            ],
            [
                'id' => 7,
                'created_at' => '2024-07-17 08:25:37',
                'updated_at' => '2024-07-17 08:25:37',
                'is_active' => 1,
                'name' => 'Phụ cấp 2 land',
                'display_order' => 7,
                'type' => 2,
            ],
            [
                'id' => 8,
                'created_at' => '2024-07-17 08:29:14',
                'updated_at' => '2024-07-17 08:29:14',
                'is_active' => 1,
                'name' => 'Giảm trừ BHXH',
                'display_order' => 8,
                'type' => 3,
            ],
            [
                'id' => 9,
                'created_at' => '2024-07-17 08:29:32',
                'updated_at' => '2024-07-17 08:29:33',
                'is_active' => 1,
                'name' => 'Giảm trừ BHYT',
                'display_order' => 9,
                'type' => 3,
            ],
            [
                'id' => 10,
                'created_at' => '2024-07-17 08:29:59',
                'updated_at' => '2024-07-17 08:29:59',
                'is_active' => 1,
                'name' => 'Giảm trừ BHTN',
                'display_order' => 10,
                'type' => 3,
            ],
        ]);
    }
}
