<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 'Active')->count();
        $inactiveProducts = Product::where('status', '!=', 'Active')->count();

        $lowStockProducts = Product::where('stock_level', '<=', 10)
            ->where('status', 'Active')
            ->count();

        $outOfStockProducts = Product::where('stock_level', 0)->count();

        $healthyStock = $activeProducts - $lowStockProducts;

        $totalSales = Sale::count();

        $totalRevenue = Sale::sum('grand_total');

        $todayRevenue = Sale::whereDate('created_at', today())
            ->sum('grand_total');

        $recentSales = Sale::latest()
            ->take(10)
            ->get();

        $weeklySales = Sale::whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $weekLabels = [];
        $weekData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $weekLabels[] = Carbon::now()->subDays($i)->format('D');
            $weekData[] = (float) ($weeklySales[$date]->total ?? 0);
        }

        $categoryBreakdown = Product::selectRaw('main_category, COUNT(*) as count')
            ->whereNotNull('main_category')
            ->groupBy('main_category')
            ->orderByDesc('count')
            ->get();

        $categoryLabels = $categoryBreakdown->pluck('main_category')->toArray();
        $categoryData = $categoryBreakdown->pluck('count')->toArray();

        return view('dashboard', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'healthyStock',
            'totalSales',
            'totalRevenue',
            'todayRevenue',
            'recentSales',
            'weekLabels',
            'weekData',
            'categoryLabels',
            'categoryData'
        ));
    }
}