<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ConfiguratorService
{
    /**
     * Main entry: recommend a build.
     * Returns a predictable array with keys: success, components, explanation, compatibility, meta.
     */
    public function recommendBuild(array $input = []): array
    {
        try {
            // Normalize inputs
            $budget = $input['budget'] ?? '<800';
            $purpose = $input['purpose'] ?? 'General';
            $cpuPref = $input['cpu_pref'] ?? '';
            $ramPref = $input['ram_pref'] ?? '';
            $formFactorPref = $input['form_factor'] ?? '';
            $targetPrice = isset($input['target_price']) && is_numeric($input['target_price']) ? (float)$input['target_price'] : null;

            // Load components (fallback dataset guaranteed)
            $components = $this->fallbackDataset();

            // 1) Filter candidates
            $candidates = $this->decisionTreeFilter($components, [
                'budget' => $budget,
                'purpose' => $purpose,
                'cpu_pref' => $cpuPref,
                'ram_pref' => $ramPref,
                'form_factor' => $formFactorPref,
                'target_price' => $targetPrice,
            ]);

            // 2) Score using simple historical similarity
            $scores = $this->knnScore($this->loadHistoricalBuilds(), [
                'budget' => $budget,
                'purpose' => $purpose,
                'target_price' => $targetPrice,
            ], $candidates);

            // 3) Choose top per category
            $chosen = $this->chooseTopPerCategory($candidates, $scores);

            // 4) Compatibility check
            $compatErrors = $this->checkCompatibility($chosen);

            // 5) Prepare UI-friendly components array
            $componentsWithReasons = [];
            $totalPrice = 0.0;
            foreach ($chosen as $category => $comp) {
                if (!$comp) continue;
                $score = $scores[$comp['id']] ?? 0;
                $importance = $this->computeImportance($comp, $score, $category, $purpose, $budget);
                $evidence = $this->buildEvidence($comp, $score, $input);
                $reason = $this->generateReason($comp, $input, $score);
                $reasonHtml = $this->generateReasonHtml($comp, $evidence, $importance);

                $componentsWithReasons[] = [
                    'id' => $comp['id'],
                    'category' => $category,
                    'name' => $comp['name'],
                    'price' => round((float)$comp['price'], 2),
                    'reason' => $reason,
                    'reason_html' => $reasonHtml,
                    'evidence' => $evidence,
                    'importance' => $importance,
                    'specs' => $comp['specs'] ?? [],
                ];
                $totalPrice += (float)($comp['price'] ?? 0);
            }

            $explanation = "Recommended build for {$purpose} within {$budget}.";
            if ($targetPrice) $explanation .= " Target price: ₱" . number_format($targetPrice, 2);

            return [
                'success' => empty($compatErrors),
                'components' => $componentsWithReasons,
                'explanation' => $explanation,
                'compatibility' => $compatErrors,
                'meta' => [
                    'estimated_total' => round($totalPrice, 2),
                    'candidate_counts' => array_map(fn($c) => count($c), $candidates),
                ],
            ];
        } catch (\Throwable $e) {
            Log::error('ConfiguratorService::recommendBuild error: '.$e->getMessage(), ['trace' => $e->getTraceAsString(), 'input' => $input]);
            return [
                'success' => false,
                'components' => [],
                'explanation' => 'Failed to compute recommendation due to internal error.',
                'compatibility' => [],
                'meta' => ['estimated_total' => 0],
                'message' => 'Internal service error: ' . $e->getMessage()
            ];
        }
    }

    protected function fallbackDataset(): array
    {
        return [
            ['id'=>'cpu_i5_10400','name'=>'Intel i5-10400','category'=>'CPU','price'=>150.00,'tier'=>1,'specs'=>['socket'=>'LGA1200','tdp'=>65]],
            ['id'=>'cpu_i7_10700','name'=>'Intel i7-10700','category'=>'CPU','price'=>320.00,'tier'=>2,'specs'=>['socket'=>'LGA1200','tdp'=>65]],
            ['id'=>'cpu_ryzen5_5600','name'=>'AMD Ryzen 5 5600','category'=>'CPU','price'=>180.00,'tier'=>1,'specs'=>['socket'=>'AM4','tdp'=>65]],
            ['id'=>'mb_asus_b460','name'=>'ASUS B460','category'=>'Motherboard','price'=>110.00,'tier'=>1,'specs'=>['socket'=>'LGA1200','form_factor'=>'ATX','ram_type'=>'DDR4']],
            ['id'=>'mb_msi_b550','name'=>'MSI B550','category'=>'Motherboard','price'=>140.00,'tier'=>2,'specs'=>['socket'=>'AM4','form_factor'=>'ATX','ram_type'=>'DDR4']],
            ['id'=>'ram_16_3200','name'=>'16GB DDR4 3200','category'=>'RAM','price'=>70.00,'tier'=>1,'specs'=>['type'=>'DDR4']],
            ['id'=>'ram_32_5600','name'=>'32GB DDR5 5600','category'=>'RAM','price'=>220.00,'tier'=>3,'specs'=>['type'=>'DDR5']],
            ['id'=>'gpu_gtx1660','name'=>'NVIDIA GTX 1660','category'=>'GPU','price'=>220.00,'tier'=>1,'specs'=>['tdp'=>120]],
            ['id'=>'gpu_rtx3060','name'=>'NVIDIA RTX 3060','category'=>'GPU','price'=>400.00,'tier'=>2,'specs'=>['tdp'=>170]],
            ['id'=>'psu_650','name'=>'650W PSU','category'=>'PSU','price'=>80.00,'tier'=>1,'specs'=>['watt'=>650]],
            ['id'=>'psu_750','name'=>'750W PSU','category'=>'PSU','price'=>110.00,'tier'=>2,'specs'=>['watt'=>750]],
            ['id'=>'case_mid','name'=>'Mid Tower Case','category'=>'Case','price'=>60.00,'tier'=>1,'specs'=>['form_factor'=>'ATX']],
            ['id'=>'case_itx','name'=>'Mini ITX Case','category'=>'Case','price'=>90.00,'tier'=>2,'specs'=>['form_factor'=>'ITX']],
            ['id'=>'storage_ssd_1tb','name'=>'1TB NVMe SSD','category'=>'Storage','price'=>90.00,'tier'=>1,'specs'=>['type'=>'NVMe']],
        ];
    }

    protected function decisionTreeFilter(array $components, array $input): array
    {
        $budget = $input['budget'] ?? '<800';
        $cpuPref = $input['cpu_pref'] ?? '';
        $ramPref = $input['ram_pref'] ?? '';
        $formFactor = $input['form_factor'] ?? '';
        $targetPrice = $input['target_price'] ?? null;

        $grouped = [];
        foreach ($components as $c) $grouped[$c['category']][] = $c;

        $candidates = [];
        foreach ($grouped as $cat => $items) {
            foreach ($items as $it) {
                // Budget guard for expensive categories
                if (in_array($cat, ['CPU','GPU'])) {
                    if ($budget === '<800' && $it['price'] > 800) continue;
                    if ($budget === '800-1500' && $it['price'] > 1500) continue;
                }
                // CPU preference
                if ($cat === 'CPU' && $cpuPref) {
                    if (stripos($it['name'], $cpuPref) === false) continue;
                }
                // RAM type preference
                if ($cat === 'RAM' && $ramPref) {
                    $specType = $it['specs']['type'] ?? ($it['specs']['ram_type'] ?? null);
                    if ($specType && $ramPref && strcasecmp($specType, $ramPref) !== 0) continue;
                }
                // Form factor
                if ($formFactor && isset($it['specs']['form_factor']) && $it['specs']['form_factor'] !== $formFactor) {
                    if (in_array($cat, ['Motherboard','Case'])) continue;
                }
                $candidates[$cat][] = $it;
            }
        }

        $expected = ['CPU','Motherboard','RAM','GPU','Storage','PSU','Case'];
        foreach ($expected as $e) if (!isset($candidates[$e])) $candidates[$e] = [];

        return $candidates;
    }

    protected function knnScore(array $builds, array $input, array $candidates): array
    {
        $scores = [];
        $budget = $input['budget'] ?? '<800';
        $purpose = $input['purpose'] ?? 'General';
        $targetPrice = $input['target_price'] ?? null;

        foreach ($builds as $b) {
            $sim = 0;
            if (($b['purpose'] ?? '') === $purpose) $sim += 2;
            if ($this->budgetCategory($b['total'] ?? 0) === $budget) $sim += 1;
            if ($targetPrice && isset($b['total'])) {
                $diff = abs(($b['total'] ?? 0) - $targetPrice);
                if ($diff <= ($targetPrice * 0.15)) $sim += 1;
            }
            foreach ($b['components'] as $cid) $scores[$cid] = ($scores[$cid] ?? 0) + $sim;
        }

        foreach ($candidates as $cat => $items) foreach ($items as $it) if (!isset($scores[$it['id']])) $scores[$it['id']] = 0;

        return $scores;
    }

    protected function budgetCategory($total): string
    {
        if ($total < 800) return '<800';
        if ($total <= 1500) return '800-1500';
        return '>1500';
    }

    protected function chooseTopPerCategory(array $candidates, array $scores): array
    {
        $chosen = [];
        foreach ($candidates as $cat => $items) {
            if (empty($items)) { $chosen[$cat] = null; continue; }
            usort($items, function ($a, $b) use ($scores) {
                $sa = $scores[$a['id']] ?? 0;
                $sb = $scores[$b['id']] ?? 0;
                if ($sa === $sb) return $a['price'] <=> $b['price'];
                return $sb <=> $sa;
            });
            $chosen[$cat] = $items[0];
        }
        return $chosen;
    }

    protected function checkCompatibility(array $chosen): array
    {
        $errors = [];
        $socket = null;
        $formFactor = null;
        $ramType = null;
        $totalTdp = 0;
        $psuWatt = null;

        foreach ($chosen as $cat => $c) {
            if (!$c) continue;
            $specs = $c['specs'] ?? [];
            if (isset($specs['socket'])) {
                if ($socket === null) $socket = $specs['socket'];
                elseif ($socket !== $specs['socket']) $errors[] = "Socket mismatch (expected {$socket}, found {$specs['socket']}).";
            }
            if (isset($specs['form_factor'])) {
                if ($formFactor === null) $formFactor = $specs['form_factor'];
                elseif ($formFactor !== $specs['form_factor']) $errors[] = "Form factor mismatch (expected {$formFactor}, found {$specs['form_factor']}).";
            }
            if (isset($specs['type']) || isset($specs['ram_type'])) {
                $rt = $specs['type'] ?? $specs['ram_type'] ?? null;
                if ($ramType === null) $ramType = $rt;
                elseif ($rt && $ramType !== $rt) $errors[] = "RAM type mismatch (expected {$ramType}, found {$rt}).";
            }
            if (isset($specs['tdp'])) $totalTdp += (int)$specs['tdp'];
            if ($cat === 'PSU' && isset($specs['watt'])) $psuWatt = (int)$specs['watt'];
        }

        if ($psuWatt === null) $errors[] = "PSU wattage unknown or no PSU selected.";
        else {
            $recommended = (int)ceil($totalTdp * 1.2);
            if ($psuWatt < $recommended) $errors[] = "PSU wattage may be insufficient. Recommended >= {$recommended}W based on estimated TDP {$totalTdp}W.";
        }

        return $errors;
    }

    protected function computeImportance(array $component, $score, $category, $purpose, $budget): int
    {
        $imp = 0;
        $imp += ($component['tier'] ?? 1) * 2;
        $imp += min(10, (int)$score);
        if ($category === 'GPU' && $purpose === 'Gaming') $imp += 3;
        if ($category === 'CPU' && $purpose === 'Workstation') $imp += 3;
        if (($component['price'] ?? 0) > 300) $imp += 1;
        return (int)$imp;
    }

    protected function buildEvidence(array $component, $score, array $input): array
    {
        $e = [];
        $e[] = ['label' => 'Tier', 'value' => (string)($component['tier'] ?? 1)];
        if (!empty($component['specs']['socket'])) $e[] = ['label' => 'Socket', 'value' => $component['specs']['socket']];
        if (!empty($component['specs']['type'])) $e[] = ['label' => 'RAM', 'value' => $component['specs']['type']];
        if (!empty($component['specs']['form_factor'])) $e[] = ['label' => 'Form', 'value' => $component['specs']['form_factor']];
        if (!empty($component['specs']['tdp'])) $e[] = ['label' => 'TDP', 'value' => (string)$component['specs']['tdp'] . 'W'];
        if ($score > 0) $e[] = ['label' => 'KNN', 'value' => (string)$score];
        return $e;
    }

    protected function generateReason(array $component, array $input = [], $score = 0): string
    {
        $parts = [];
        $parts[] = "Price: ₱" . number_format($component['price'] ?? 0, 2);
        $parts[] = "Tier: " . ($component['tier'] ?? 1);
        if ($score > 0) $parts[] = "Appears in similar builds (score {$score})";
        if (!empty($component['specs']['socket'])) $parts[] = "Socket: {$component['specs']['socket']}";
        return implode('; ', $parts);
    }

    protected function generateReasonHtml(array $component, array $evidence, int $importance): string
    {
        $chips = [];
        foreach ($evidence as $ev) {
            $label = htmlspecialchars($ev['label'], ENT_QUOTES, 'UTF-8');
            $value = htmlspecialchars($ev['value'], ENT_QUOTES, 'UTF-8');
            $chips[] = "<small class=\"chip\">{$label}: <strong>{$value}</strong></small>";
        }
        $chipsHtml = implode(' ', $chips);
        $name = htmlspecialchars($component['name'], ENT_QUOTES, 'UTF-8');
        $price = '₱' . number_format($component['price'] ?? 0, 2);
        return "<div class=\"reason-html\"><div style=\"margin-bottom:6px\"><strong>{$name}</strong> <small style=\"color:#bfbfbf\">{$price}</small></div><div>{$chipsHtml}</div></div>";
    }

    protected function loadHistoricalBuilds(): array
    {
        return [
            ['id'=>'b1','purpose'=>'Gaming','total'=>1200,'components'=>['cpu_i7_10700','mb_asus_b460','ram_16_3200','gpu_rtx3060','psu_750','case_mid']],
            ['id'=>'b2','purpose'=>'Office','total'=>700,'components'=>['cpu_i5_10400','mb_asus_b460','ram_16_3200','psu_650','case_mid']],
            ['id'=>'b3','purpose'=>'Workstation','total'=>2000,'components'=>['cpu_ryzen5_5600','mb_msi_b550','ram_32_5600','gpu_rtx3060','psu_750','case_mid']],
        ];
    }
}
