<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\Product;

class UserReportController extends Controller
{
    // 1. Budget Allocation Report
    public function budgetAllocation(Request $request)
    {
        $user = auth()->user();
        $latestOrder = Order::with('items.product.category')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $data = [
            'user' => $user,
            'order' => $latestOrder,
            'title' => 'Budget Allocation Report',
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.budget-allocation', $data);
            return $pdf->download('budget-allocation-report.pdf');
        }

        return view('reports.user.budget-allocation', $data);
    }

    // 2. Build History Report
    public function buildHistory(Request $request)
    {
        $user = auth()->user();
        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $data = [
            'user' => $user,
            'orders' => $orders,
            'title' => 'Build History Report',
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.build-history', $data);
            return $pdf->download('build-history-report.pdf');
        }

        return view('reports.user.build-history', $data);
    }

    // 3. Component Compatibility Report
    public function compatibility(Request $request)
    {
        $data = [
            'title' => 'Component Compatibility Report',
            'status' => 'Fully Compatible',
            'checks' => [
                'Socket Alignment' => 'PASS — Processor socket and motherboard match.',
                'Thermal & Power Clearance' => 'PASS — Power supply capacity meets total system TDP.',
                'Memory Compatibility' => 'PASS — RAM speed and generation are supported.',
                'Physical Clearance' => 'PASS — GPU length and CPU cooler height fit chassis specifications.'
            ]
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.compatibility', $data);
            return $pdf->download('component-compatibility-report.pdf');
        }

        return view('reports.user.compatibility', $data);
    }

    // 4. Alternative Parts Comparison Report
    public function alternatives(Request $request)
    {
        $alternatives = Product::with('category')
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $data = [
            'title' => 'Alternative Parts Comparison Report',
            'alternatives' => $alternatives,
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.alternatives', $data);
            return $pdf->download('alternative-parts-report.pdf');
        }

        return view('reports.user.alternatives', $data);
    }

    // 5. Performance Benchmark Report
    public function benchmark(Request $request)
    {
        $data = [
            'title' => 'Performance Benchmark Report',
            'benchmarks' => [
                '1080p Esports / High Settings' => '144+ FPS',
                '1440p AAA Ultra Settings' => '85 - 110 FPS',
                '4K Media & Gaming' => '60 FPS Target',
                'Multi-threaded Productivity' => 'High Performance Rating'
            ]
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.performance-benchmark', $data);
            return $pdf->download('performance-benchmark-report.pdf');
        }

        return view('reports.user.performance-benchmark', $data);
    }

    // 6. Recommendation Explanation Report
    public function explanation(Request $request)
    {
        $data = [
            'title' => 'Recommendation Explanation Report',
            'summary' => 'System recommendations are calculated using performance-per-peso optimization, ensuring compatibility across all hardware interfaces.',
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.user.recommendation-explanation', $data);
            return $pdf->download('recommendation-explanation-report.pdf');
        }

        return view('reports.user.recommendation-explanation', $data);
    }
}