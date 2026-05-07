<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Define categories with sample products
        $catalog = [
            'CPU' => [
                [
                    'name' => 'Intel Core i9-13900K',
                    'price' => 32000,
                    'description' => '13th Gen Intel Core i9 processor with 24 cores and 32 threads.',
                    'details' => 'Base Clock: 3.0GHz, Turbo: 5.8GHz, Socket: LGA1700',
                    'image' => 'products/cpu_i9_13900k.jpg',
                ],
                [
                    'name' => 'AMD Ryzen 9 7950X',
                    'price' => 29000,
                    'description' => 'High-performance AMD Ryzen processor with 16 cores and 32 threads.',
                    'details' => 'Base Clock: 4.5GHz, Turbo: 5.7GHz, Socket: AM5',
                    'image' => 'products/cpu_ryzen9_7950x.jpg',
                ],
                // … add 8 more CPUs
            ],
            'GPU' => [
                [
                    'name' => 'NVIDIA GeForce RTX 4090',
                    'price' => 95000,
                    'description' => 'Flagship NVIDIA GPU with 24GB GDDR6X memory.',
                    'details' => 'CUDA Cores: 16384, Boost Clock: 2.52GHz',
                    'image' => 'products/gpu_rtx4090.jpg',
                ],
                [
                    'name' => 'AMD Radeon RX 7900 XTX',
                    'price' => 65000,
                    'description' => 'High-end AMD GPU with 24GB GDDR6 memory.',
                    'details' => 'Stream Processors: 6144, Boost Clock: 2.5GHz',
                    'image' => 'products/gpu_rx7900xtx.jpg',
                ],
                // … add 8 more GPUs
            ],
            'RAM' => [
                [
                    'name' => 'Corsair Vengeance DDR5 32GB (2x16GB)',
                    'price' => 12000,
                    'description' => 'High-speed DDR5 memory kit for gaming and productivity.',
                    'details' => 'Speed: 6000MHz, CAS Latency: CL36',
                    'image' => 'products/ram_corsair_ddr5.jpg',
                ],
                [
                    'name' => 'G.Skill Trident Z5 RGB DDR5 32GB',
                    'price' => 13000,
                    'description' => 'Premium DDR5 memory with RGB lighting.',
                    'details' => 'Speed: 6400MHz, CAS Latency: CL32',
                    'image' => 'products/ram_gskill_tridentz5.jpg',
                ],
                // … add 8 more RAM kits
            ],
            'Storage' => [
                [
                    'name' => 'Samsung 980 Pro NVMe SSD 1TB',
                    'price' => 8000,
                    'description' => 'High-performance NVMe SSD for gaming and productivity.',
                    'details' => 'Read Speed: 7000MB/s, Write Speed: 5000MB/s',
                    'image' => 'products/storage_samsung980pro.jpg',
                ],
                [
                    'name' => 'WD Black SN850X NVMe SSD 2TB',
                    'price' => 15000,
                    'description' => 'Top-tier NVMe SSD with blazing fast speeds.',
                    'details' => 'Read Speed: 7300MB/s, Write Speed: 6600MB/s',
                    'image' => 'products/storage_wdblack_sn850x.jpg',
                ],
                // … add 8 more storage devices
            ],
        ];

        // Loop through categories and seed products
        foreach ($catalog as $categoryName => $products) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($products as $product) {
                Product::create([
                    'name'        => $product['name'],
                    'slug'        => Str::slug($product['name']),
                    'description' => $product['description'],
                    'details'     => $product['details'],
                    'price'       => $product['price'],
                    'stock'       => rand(5, 50),
                    'category_id' => $category->id,
                    'image'       => $product['image'], // store in /storage/app/public/products
                ]);
            }
        }
    }
}