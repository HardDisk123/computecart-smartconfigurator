<?php

namespace App\Services;

class ConfiguratorService
{
    /**
     * Core recommendation algorithm.
     */
    public function generateBuild(array $params): array
    {
        $budgetTier = $params['budget'] ?? '800-1500';
        $targetPrice = $params['target_price'] ?? null;
        $purpose = $params['purpose'] ?? 'Gaming & Streaming';
        $resolution = $params['resolution'] ?? '1080p';
        $cpuPref = $params['cpu_pref'] ?? 'any';
        $ramPref = $params['ram_pref'] ?? 'any';
        $formFactor = $params['form_factor'] ?? 'ATX';

        // 1. Hardware Selection Engine
        $components = $this->selectComponents($budgetTier, $targetPrice, $purpose, $cpuPref, $ramPref, $formFactor);

        // 2. Compatibility Matrix Check
        $compatibilityWarnings = $this->checkCompatibility($components);

        // 3. Dynamic FPS Benchmarks
        $fpsEstimates = $this->calculateFpsEstimates($components, $resolution);

        // 4. Summary & Pricing
        $totalPrice = array_sum(array_column($components, 'price'));
        $explanation = $this->generateExplanation($purpose, $resolution, $totalPrice, $components);

        return [
            'components'             => $components,
            'total_price'            => $totalPrice,
            'explanation'            => $explanation,
            'compatibility_warnings' => $compatibilityWarnings,
            'fps_estimates'          => $fpsEstimates,
        ];
    }

    protected function selectComponents(?string $budgetTier, ?float $targetPrice, string $purpose, string $cpuPref, string $ramPref, string $formFactor): array
    {
        $isHighTier = ($budgetTier === '>1500') || ($targetPrice && $targetPrice >= 75000);
        $isEntryTier = ($budgetTier === '<800') || ($targetPrice && $targetPrice <= 35000);

        // CPU
        if ($cpuPref === 'AMD') {
            $cpu = $isHighTier 
                ? ['id' => 101, 'name' => 'AMD Ryzen 7 7800X3D', 'category' => 'CPU', 'price' => 24500, 'socket' => 'AM5', 'specs' => '8 Cores / 16 Threads • 96MB L3 Cache']
                : ['id' => 102, 'name' => 'AMD Ryzen 5 7600X', 'category' => 'CPU', 'price' => 13200, 'socket' => 'AM5', 'specs' => '6 Cores / 12 Threads • 5.3 GHz Boost'];
        } else {
            $cpu = $isHighTier
                ? ['id' => 103, 'name' => 'Intel Core i7-14700K', 'category' => 'CPU', 'price' => 25800, 'socket' => 'LGA1700', 'specs' => '20 Cores / 28 Threads • 5.6 GHz Boost']
                : ['id' => 104, 'name' => 'Intel Core i5-13400F', 'category' => 'CPU', 'price' => 10800, 'socket' => 'LGA1700', 'specs' => '10 Cores / 16 Threads • 4.6 GHz Boost'];
        }

        // GPU
        if ($isHighTier) {
            $gpu = ['id' => 201, 'name' => 'NVIDIA GeForce RTX 4070 Ti Super 16GB', 'category' => 'GPU', 'price' => 52000, 'vram' => '16GB', 'tdp' => 285, 'specs' => '16GB GDDR6X • DLSS 3.5 • Ray Tracing'];
        } elseif ($isEntryTier) {
            $gpu = ['id' => 202, 'name' => 'AMD Radeon RX 6600 8GB', 'category' => 'GPU', 'price' => 12900, 'vram' => '8GB', 'tdp' => 132, 'specs' => '8GB GDDR6 • 1080p High Performance'];
        } else {
            $gpu = ['id' => 203, 'name' => 'NVIDIA GeForce RTX 4060 Ti 8GB', 'category' => 'GPU', 'price' => 23500, 'vram' => '8GB', 'tdp' => 160, 'specs' => '8GB GDDR6 • DLSS 3 Frame Generation'];
        }

        // Motherboard
        $ramType = ($cpu['socket'] === 'AM5' || $ramPref === 'DDR5' || $isHighTier) ? 'DDR5' : 'DDR4';
        $moboForm = in_array($formFactor, ['ATX', 'mATX', 'ITX']) ? $formFactor : 'ATX';
        $motherboard = [
            'id'       => 301,
            'name'     => ($cpu['socket'] === 'AM5') ? "MSI MAG B650 Mortar {$moboForm} WiFi" : "ASUS TUF Gaming B760-Plus {$moboForm}",
            'category' => 'Motherboard',
            'price'    => 10500,
            'socket'   => $cpu['socket'],
            'ram_type' => $ramType,
            'form'     => $moboForm,
            'specs'    => "Socket {$cpu['socket']} • {$ramType} Support • PCIe 4.0",
        ];

        // RAM
        $ram = [
            'id'       => 401,
            'name'     => $ramType === 'DDR5' ? 'G.Skill Trident Z5 RGB 32GB (2x16GB) DDR5 6000MHz' : 'Corsair Vengeance LPX 16GB (2x8GB) DDR4 3200MHz',
            'category' => 'RAM',
            'price'    => $ramType === 'DDR5' ? 7600 : 2900,
            'type'     => $ramType,
            'specs'    => $ramType === 'DDR5' ? '32GB Dual Channel • CL30 Ultra Fast' : '16GB Dual Channel • Low Profile',
        ];

        // Storage
        $storage = [
            'id'       => 501,
            'name'     => $isHighTier ? 'Samsung 990 PRO 2TB PCIe 4.0 NVMe M.2 SSD' : 'Kingston NV2 1TB PCIe 4.0 NVMe M.2 SSD',
            'category' => 'Storage',
            'price'    => $isHighTier ? 8900 : 3800,
            'specs'    => $isHighTier ? 'Read up to 7450 MB/s • High Endurance' : 'Read up to 3500 MB/s • Reliable NVMe',
        ];

        // Power Supply
        $psuWattage = $isHighTier ? 750 : 650;
        $psu = [
            'id'       => 601,
            'name'     => "CORSAIR RM{$psuWattage}e {$psuWattage}W 80+ Gold Fully Modular",
            'category' => 'Power Supply',
            'price'    => $isHighTier ? 6200 : 4400,
            'wattage'  => $psuWattage,
            'specs'    => "{$psuWattage}W Rating • 80 PLUS Gold Certified • Zero RPM Fan Mode",
        ];

        // Case
        $case = [
            'id'       => 701,
            'name'     => "NZXT H5 Flow {$moboForm} Tempered Glass Mid-Tower",
            'category' => 'Case',
            'price'    => 4600,
            'form'     => $moboForm,
            'specs'    => 'Perforated Front Panel • Dual Pre-installed Fans • Clean Cable Management',
        ];

        return [$cpu, $gpu, $motherboard, $ram, $storage, $psu, $case];
    }

    protected function checkCompatibility(array $components): array
    {
        $warnings = [];
        $cpu = collect($components)->firstWhere('category', 'CPU');
        $mobo = collect($components)->firstWhere('category', 'Motherboard');
        $ram = collect($components)->firstWhere('category', 'RAM');
        $gpu = collect($components)->firstWhere('category', 'GPU');
        $psu = collect($components)->firstWhere('category', 'Power Supply');

        if ($cpu && $mobo && isset($cpu['socket'], $mobo['socket']) && $cpu['socket'] !== $mobo['socket']) {
            $warnings[] = "Socket Incompatibility: CPU requires {$cpu['socket']}, but Motherboard has {$mobo['socket']}.";
        }

        if ($mobo && $ram && isset($mobo['ram_type'], $ram['type']) && $mobo['ram_type'] !== $ram['type']) {
            $warnings[] = "Memory Mismatch: Motherboard requires {$mobo['ram_type']}, but {$ram['type']} was selected.";
        }

        $gpuTdp = $gpu['tdp'] ?? 150;
        $recommendedWattage = $gpuTdp + 280;
        if ($psu && isset($psu['wattage']) && $psu['wattage'] < $recommendedWattage) {
            $warnings[] = "Power Headroom Warning: System estimated load is ~{$recommendedWattage}W. The selected {$psu['wattage']}W PSU may operate near maximum load.";
        }

        return $warnings;
    }

    protected function calculateFpsEstimates(array $components, string $resolution): array
    {
        $gpu = collect($components)->firstWhere('category', 'GPU');
        $gpuName = $gpu['name'] ?? '';

        $resMod = match ($resolution) {
            '1440p' => 0.78,
            '4k'    => 0.50,
            default => 1.00,
        };

        $gpuMod = 1.0;
        if (str_contains($gpuName, '4090')) $gpuMod = 2.4;
        elseif (str_contains($gpuName, '4080') || str_contains($gpuName, '4070 Ti')) $gpuMod = 1.85;
        elseif (str_contains($gpuName, '4070') || str_contains($gpuName, '7800 XT')) $gpuMod = 1.45;
        elseif (str_contains($gpuName, '4060 Ti')) $gpuMod = 1.20;
        elseif (str_contains($gpuName, '6600')) $gpuMod = 0.80;

        $games = [
            ['name' => 'Valorant / CS2', 'icon' => 'fa-crosshair', 'base' => 310],
            ['name' => 'Call of Duty: Warzone', 'icon' => 'fa-person-rifle', 'base' => 145],
            ['name' => 'Cyberpunk 2077', 'icon' => 'fa-vr-cardboard', 'base' => 80],
            ['name' => 'GTA V / GTA VI Ready', 'icon' => 'fa-car-side', 'base' => 120],
            ['name' => 'Apex Legends', 'icon' => 'fa-shield-halved', 'base' => 165],
        ];

        $results = [];
        foreach ($games as $game) {
            $calcBase = $game['base'] * $resMod * $gpuMod;

            $results[] = [
                'name'    => $game['name'],
                'icon'    => $game['icon'],
                'lowFps'  => (int) round($calcBase * 1.35),
                'medFps'  => (int) round($calcBase * 1.00),
                'highFps' => (int) round($calcBase * 0.75),
            ];
        }

        return $results;
    }

    protected function generateExplanation(string $purpose, string $resolution, float $totalPrice, array $components): string
    {
        $gpu = collect($components)->firstWhere('category', 'GPU')['name'] ?? 'Graphics Card';
        $cpu = collect($components)->firstWhere('category', 'CPU')['name'] ?? 'Processor';

        return "This build is engineered for maximum synergy between the {$cpu} and {$gpu}. Optimized specifically for {$purpose} at {$resolution} resolution, ensuring high framerates, low thermal throttling, and direct upgrade pathways.";
    }
}