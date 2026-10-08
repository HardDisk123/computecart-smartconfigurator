<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category'    => 'Processors',
                'name'        => 'AMD Ryzen 9 9950X3D',
                'price'       => 47900,
                'stock'       => 15,
                'description' => 'The ultimate 16-core desktop CPU with 2nd gen AMD 3D V-Cache Technology, delivering unprecedented performance for the most demanding gamers and creators.',
                'details'     => 'Socket: AM5 | Cores/Threads: 16C/32T | Base Clock: 4.3GHz | Boost Clock: 5.7GHz | L3 Cache: 128MB | TDP: 170W',
            ],
            [
                'category'    => 'Motherboards',
                'name'        => 'ASUS ROG Crosshair X870E Hero',
                'price'       => 39950,
                'stock'       => 10,
                'description' => 'AI PC-ready motherboard offering unyielding power delivery, robust thermal management, hyperspeed Wi-Fi 7 connectivity, and comprehensive PCIe 5.0 support.',
                'details'     => 'Form Factor: ATX | Chipset: X870E | Socket: AM5 | Memory Support: DDR5 up to 192GB (8200+MT/s OC) | Connectivity: Wi-Fi 7, Dual USB4, 5Gb Ethernet',
            ],
            [
                'category'    => 'Graphics Cards',
                'name'        => 'ASUS ROG Astral GeForce RTX 5090',
                'price'       => 149990, // Bumped slightly to reflect the premium ROG AIB pricing
                'stock'       => 5,
                'description' => 'The ultimate Blackwell GPU enhanced with the revolutionary ROG Astral thermal design, offering unmatched gaming and AI performance with a 32GB GDDR7 frame buffer and striking Aura Sync aesthetics.',
                'details'     => 'VRAM: 32GB GDDR7 | Bus Width: 512-bit | CUDA Cores: 21760 | Memory Bandwidth: ~1.79 TB/s | TDP: 600W (Factory OC)',
            ],
            [
                'category'    => 'Memory',
                'name'        => 'G.Skill Trident Z5 Neo RGB 32GB (2x16GB) DDR5 8000MHz',
                'price'       => 10995,
                'stock'       => 20,
                'description' => 'Extreme-performance DDR5 memory engineered for AMD EXPO, featuring sleek heatspreaders and customizable RGB lighting.',
                'details'     => 'Capacity: 32GB (2x 16GB) | Speed: 8000 MT/s | Latency: CL38-48-48-128 | Voltage: 1.45V | Profile: AMD EXPO',
            ],
            [
                'category'    => 'Internal Storage',
                'name'        => 'Corsair MP700 Pro XT 4TB PCIe 5.0 NVMe M.2 SSD',
                'price'       => 28500,
                'stock'       => 12,
                'description' => 'Record-breaking Gen5 NVMe SSD delivering maximum bandwidth and sustained performance for heavy workloads and rapid load times.',
                'details'     => 'Capacity: 4TB | Interface: PCIe Gen 5.0 x4, NVMe 2.0 | Max Read Speed: 14,900 MB/s | Max Write Speed: 14,700 MB/s | Form Factor: M.2 2280',
            ],
            [
                'category'    => 'External Storage',
                'name'        => 'SanDisk PRO-G40 SSD 4TB',
                'price'       => 24500,
                'stock'       => 15,
                'description' => 'Ultra-rugged, dual-mode NVMe external SSD built for professional content creators needing extreme on-the-go transfer speeds.',
                'details'     => 'Capacity: 4TB | Interface: Thunderbolt 3 (40Gbps) & USB 3.2 Gen 2 (10Gbps) | Read Speed: Up to 3,000 MB/s | Durability: IP68 water/dust resistance',
            ],
            [
                'category'    => 'Power Supplies',
                'name'        => 'CORSAIR AX1600i 1600W Digital ATX',
                'price'       => 28995,
                'stock'       => 8,
                'description' => 'The pinnacle of ATX power supplies, offering 1600W of continuous power with 80 PLUS Titanium efficiency and digital monitoring.',
                'details'     => 'Wattage: 1600W | Rating: 80 PLUS Titanium | Cable Type: Fully Modular | Fan Size: 140mm FDB | Feature: DSP, GaN Totem Pole PFC',
            ],
            [
                'category'    => 'PC Cases',
                'name'        => 'Lian Li O11 Vision (White)',
                'price'       => 8600,
                'stock'       => 10,
                'description' => 'A visionary dual-chamber chassis featuring a seamless 3-piece tempered glass design to showcase your high-end components with zero pillar obstruction.',
                'details'     => 'Type: Mid-Tower | Mainboard Support: E-ATX, ATX, Micro-ATX, Mini-ITX | GPU Clearance: 455mm | Radiator Support: Up to 360mm side/bottom',
            ],
            [
                'category'    => 'Chassis Fans',
                'name'        => 'Lian Li UNI FAN TL LCD 140mm (Reverse Blade, 3-Pack)',
                'price'       => 8200,
                'stock'       => 25,
                'description' => 'Premium daisy-chainable cooling fans featuring an integrated customizable LCD screen on the fan hub for ultimate personalized aesthetics.',
                'details'     => 'Size: 140 x 140 x 28 mm | Connector: Daisy-chain | Max Speed: 1600 RPM | Airflow: 64 CFM | Feature: 1.6-inch LCD Display',
            ],
            [
                'category'    => 'CPU Coolers',
                'name'        => 'ASUS ROG Ryujin III 360 ARGB',
                'price'       => 18500,
                'stock'       => 12,
                'description' => 'Flagship AIO liquid cooler powered by an 8th Gen Asetek pump, magnetic daisy-chain fans, and a large customizable full-color LCD screen.',
                'details'     => 'Radiator Size: 360mm | Pump: Asetek 8th Gen (Up to 3600 RPM) | Fans: 3x 120mm Magnetic ARGB | Display: 3.5-inch LCD',
            ],
            [
                'category'    => 'Thermal Paste',
                'name'        => 'Thermal Grizzly Kryonaut Extreme (2g)',
                'price'       => 1250,
                'stock'       => 40,
                'description' => 'High-performance thermal compound developed specifically for extreme overclocking, handling massive heat loads from flagship CPUs.',
                'details'     => 'Weight: 2g | Thermal Conductivity: 14.2 W/mK | Operating Temp: -250°C to +350°C | Electrical Conductivity: Non-conductive',
            ],
            [
                'category'    => 'Tools',
                'name'        => 'iFixit Pro Tech Toolkit',
                'price'       => 4500,
                'stock'       => 20,
                'description' => 'The ultimate toolkit for PC builders and technicians, containing 64 precision bits, anti-static tools, and everything needed to tear down or build up hardware.',
                'details'     => 'Bit Count: 64 Precision Bits | Handle: Ergonomic Magnetized Aluminum | Case: Magnetized Canvas Roll & Sorting Tray',
            ],
        ];

        foreach ($products as $item) {
            // Find category by name or create it if missing
            $category = Category::firstOrCreate(['name' => $item['category']]);

            Product::create([
                'category_id' => $category->id,
                'name'        => $item['name'],
                'price'       => $item['price'],
                'stock'       => $item['stock'],
                'description' => $item['description'],
                'details'     => $item['details'],
                'image'       => 'products/default.jpg',
            ]);
        }
    }
}