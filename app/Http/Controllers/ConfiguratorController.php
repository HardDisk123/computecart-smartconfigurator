<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ConfiguratorService;
use Illuminate\Support\Facades\Log;

class ConfiguratorController extends Controller
{
    /**
     * Show the configurator page.
     */
    public function show()
    {
        return view('configurator');
    }

    /**
     * API: compute a recommended build and return JSON.
     * Always returns JSON; catches exceptions and logs details.
     */
    public function recommend(Request $request, ConfiguratorService $service)
{
    try {
        Log::info('Configurator payload', $request->all());

        $payload = $request->only([
            'budget',
            'purpose',
            'cpu_pref',
            'ram_pref',
            'form_factor',
            'target_price',
            'resolution',
            'prefer_silent',
            'prefer_budget_parts'
        ]);

        $result = $service->recommendBuild($payload);

        if (!is_array($result) || !isset($result['components'])) {
            Log::error('Invalid service response', ['result' => $result]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid recommendation response format'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'components' => $result['components'],
            'explanation' => $result['explanation'] ?? '',
            'compatibility' => $result['compatibility'] ?? []
        ]);

    } catch (\Throwable $e) {
        Log::error('Recommendation error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Minimal add-to-cart stub for the demo.
     */
    public function addToCart(Request $request)
    {
        $components = $request->input('components', []);
        return response()->json([
            'success' => true,
            'added' => $components
        ], 200);
    }
}
