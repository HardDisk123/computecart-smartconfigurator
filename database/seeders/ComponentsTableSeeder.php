<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('components')->insert([
            [
                'id' => 'cpu_i5_10400',
                'name' => 'Intel i5-10400',
                'category' => 'CPU',
                'price' => 150.00,
                'tier' => 1,
                'specs' => json_encode(['socket' => 'LGA1200', 'tdp' => 65]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'cpu_i7_10700',
                'name' => 'Intel i7-10700',
                'category' => 'CPU',
                'price' => 320.00,
                'tier' => 2,
                'specs' => json_encode(['socket' => 'LGA1200', 'tdp' => 65]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'mb_asus_b460',
                'name' => 'ASUS B460',
                'category' => 'Motherboard',
                'price' => 110.00,
                'tier' => 1,
                'specs' => json_encode(['socket' => 'LGA1200', 'form_factor' => 'ATX']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'gpu_rtx3060',
                'name' => 'NVIDIA RTX 3060',
                'category' => 'GPU',
                'price' => 400.00,
                'tier' => 2,
                'specs' => json_encode(['tdp' => 170]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'ram_16_3200',
                'name' => '16GB DDR4 3200',
                'category' => 'RAM',
                'price' => 70.00,
                'tier' => 1,
                'specs' => json_encode(['type' => 'DDR4']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'psu_650',
                'name' => '650W PSU',
                'category' => 'PSU',
                'price' => 80.00,
                'tier' => 1,
                'specs' => json_encode(['watt' => 650]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'case_mid',
                'name' => 'Mid Tower Case',
                'category' => 'Case',
                'price' => 60.00,
                'tier' => 1,
                'specs' => json_encode(['form_factor' => 'ATX']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
