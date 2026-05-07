<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Chasis Fans',
            'CPU Cooler Fans',
            'Graphics Cards',
            'External Storage',
            'Internal Storage',
            'Motherboards',
            'Memory',
            'PC Cases',
            'Power Supplies',
            'Processors',
            'Thermal Paste',
            'Tools',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
