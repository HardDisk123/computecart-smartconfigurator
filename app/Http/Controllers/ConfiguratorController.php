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
            $payload = $request->only([
                'budget','purpose','cpu_pref','ram_pref','form_factor','target_price',
                'resolution','prefer_silent','prefer_budget_parts'
            ]);

            $result = $service->recommendBuild($payload);

            if (!is_array($result) || !array_key_exists('components', $result)) {
                Log::error('ConfiguratorController::recommend unexpected service response', ['result' => $result]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unexpected service response format.'
                ], 500);
            }

            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('ConfiguratorController::recommend error: '.$e->getMessage(), ['trace' => $e->getTraceAsString(), 'input' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error while computing recommendation.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Minimal add-to-cart stub for the demo.
     */
    public function addToCart(Request $request)
    {
        $components = $request->input('components', []);
        // In production: add to cart logic here.
        return response()->json(['success' => true, 'added' => $components]);
    }
}
