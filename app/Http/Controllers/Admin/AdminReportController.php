<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;

class AdminReportController extends Controller
{
    // 1. Inventory Availability Report
    public function inventoryAvailability(Request $request)
    {
        $products = Product::with('category')
            ->orderBy('stock', 'asc')
            ->get();

        $data = [
            'title' => 'Inventory Availability Report',
            'products' => $products,
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.admin.inventory-availability', $data);
            return $pdf->download('inventory-availability-report.pdf');
        }

        return view('reports.admin.inventory-availability', $data);
    }

    // 2. Popular Build Trends Report
    public function buildTrends(Request $request)
    {
        $popularProducts = Product::with('category')
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        $data = [
            'title' => 'Popular Build Trends Report',
            'products' => $popularProducts,
        ];

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.admin.build-trends', $data);
            return $pdf->download('popular-build-trends-report.pdf');
        }

        return view('reports.admin.build-trends', $data);
    }
}