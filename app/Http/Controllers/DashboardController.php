<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 'Active')->count();

        $lowStockProducts = Product::where('stock_level', '<=', 10)
            ->where('status', 'Active')
            ->count();

        $outOfStockProducts = Product::where('stock_level', 0)->count();

        $totalSales = Sale::count();

        $totalRevenue = Sale::sum('grand_total');

        $todayRevenue = Sale::whereDate('created_at', today())
            ->sum('grand_total');

        $recentSales = Sale::latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalSales',
            'totalRevenue',
            'todayRevenue',
            'recentSales'
        ));
    }
}