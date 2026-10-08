<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ConfiguratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ConfiguratorController extends Controller
{
    protected ConfiguratorService $configuratorService;

    public function __construct(ConfiguratorService $configuratorService)
    {
        $this->configuratorService = $configuratorService;
    }

    /**
     * Render the main SmartConfigurator view.
     */
    public function show(): View
    {
        return view('configurator');
    }

    /**
     * Generate optimal hardware recommendations & FPS estimates.
     */
    public function recommend(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'budget'              => 'nullable|string',
            'target_price'        => 'nullable|numeric|min:0',
            'purpose'             => 'nullable|string',
            'resolution'          => 'nullable|string|in:1080p,1440p,4k',
            'target_fps'          => 'nullable|numeric',
            'cpu_pref'            => 'nullable|string',
            'ram_pref'            => 'nullable|string',
            'form_factor'         => 'nullable|string',
            'prefer_silent'       => 'nullable|boolean',
            'prefer_budget_parts' => 'nullable|boolean',
        ]);

        try {
            $recommendation = $this->configuratorService->generateBuild($validated);

            return response()->json([
                'success'       => true,
                'components'    => $recommendation['components'],
                'explanation'   => $recommendation['explanation'],
                'compatibility' => $recommendation['compatibility_warnings'],
                'fps_estimates' => $recommendation['fps_estimates'],
                'total_price'   => $recommendation['total_price'],
                'formatted_price' => '₱' . number_format($recommendation['total_price'], 2),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate recommendation: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add entire recommended build to shopping cart session.
     */
    public function addToCart(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'components'   => 'required|array|min:1',
            'components.*' => 'required',
        ]);

        try {
            $cart = session()->get('cart', []);
            $addedItemsCount = 0;

            foreach ($validated['components'] as $component) {
                $productId = is_array($component) ? ($component['id'] ?? null) : $component;
                if (!$productId) continue;

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity']++;
                } else {
                    $cart[$productId] = [
                        'id'       => $productId,
                        'name'     => $component['name'] ?? 'PC Component',
                        'price'    => $component['price'] ?? 0,
                        'category' => $component['category'] ?? 'Hardware',
                        'quantity' => 1,
                    ];
                }
                $addedItemsCount++;
            }

            session()->put('cart', $cart);

            return response()->json([
                'success'     => true,
                'message'     => 'All ' . $addedItemsCount . ' build components added to cart successfully!',
                'cart_count'  => count($cart),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not add components to cart: ' . $e->getMessage(),
            ], 500);
        }
    }
}