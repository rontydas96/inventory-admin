<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected function calculatePercentageChange(float $current, float $previous): ?float
    {
        if ($previous == 0) {
            return $current === 0 ? 0.0 : null;
        }

        return round((($current - $previous) / abs($previous)) * 100, 2);
    }

    public function index(Request $request)
    {
        $range = $request->get('range');
        $today = Carbon::today();

        switch ($range) {
            case 'current_month':
                $from = $today->copy()->startOfMonth()->toDateString();
                $to = $today->copy()->toDateString();
                break;
            case 'last_month':
                $from = $today->copy()->subMonthNoOverflow()->startOfMonth()->toDateString();
                $to = $today->copy()->subMonthNoOverflow()->endOfMonth()->toDateString();
                break;
            case 'last_30_days':
                $from = $today->copy()->subDays(29)->toDateString();
                $to = $today->toDateString();
                break;
            case 'last_3_months':
                $from = $today->copy()->subDays(89)->toDateString();
                $to = $today->toDateString();
                break;
            case 'last_6_months':
                $from = $today->copy()->subDays(179)->toDateString();
                $to = $today->toDateString();
                break;
            case 'last_year':
                $from = $today->copy()->subDays(364)->toDateString();
                $to = $today->toDateString();
                break;
            default:
                $from = $request->get('from', $today->copy()->startOfMonth()->toDateString());
                $to = $request->get('to', $today->toDateString());
                break;
        }

        $fromDate = Carbon::parse($from)->startOfDay();
        $toDate = Carbon::parse($to)->endOfDay();

        $sales = Sale::with('items.product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->latest()
            ->get();

        $invoiceCount = $sales->count();
        $totalRevenue = $sales->sum('grand_total');
        $totalTax = $sales->sum('gst_amount');
        $totalPurchase = $sales->flatMap(function ($sale) {
            return $sale->items->map(function ($item) {
                return ($item->product?->price ?? 0) * $item->quantity;
            });
        })->sum();
        $profitLoss = $totalRevenue - $totalPurchase;
        $averageInvoice = $invoiceCount > 0 ? round($totalRevenue / $invoiceCount, 2) : 0;

        $periodDays = $fromDate->diffInDays($toDate) + 1;
        $previousTo = $fromDate->copy()->subDay();
        $previousFrom = $previousTo->copy()->subDays($periodDays - 1);

        $previousSales = Sale::with('items.product')
            ->whereBetween('created_at', [$previousFrom->startOfDay(), $previousTo->endOfDay()])
            ->latest()
            ->get();

        $previousRevenue = $previousSales->sum('grand_total');
        $previousPurchase = $previousSales->flatMap(function ($sale) {
            return $sale->items->map(function ($item) {
                return ($item->product?->price ?? 0) * $item->quantity;
            });
        })->sum();
        $previousProfit = $previousRevenue - $previousPurchase;

        $revenueGrowth = $this->calculatePercentageChange($totalRevenue, $previousRevenue);
        $profitGrowth = $this->calculatePercentageChange($profitLoss, $previousProfit);

        $lowStockProducts = Product::where('stock_level', '<=', 10)
            ->where('status', 'Active')
            ->orderBy('stock_level')
            ->get();

        return view('reports.index', compact(
            'from',
            'to',
            'range',
            'sales',
            'invoiceCount',
            'totalRevenue',
            'totalTax',
            'totalPurchase',
            'profitLoss',
            'averageInvoice',
            'revenueGrowth',
            'profitGrowth',
            'previousFrom',
            'previousTo',
            'lowStockProducts'
        ));
    }

    public function exportSalesCsv(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->toDateString());

        $sales = Sale::with('items.product')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->latest()
            ->get();

        $filename = "sales-report-{$from}-to-{$to}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return new StreamedResponse(function () use ($sales) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Invoice No',
                'Date',
                'Customer',
                'Purchase Cost',
                'Revenue',
                'GST',
                'Profit / Loss',
                'PO No',
                'Challan No',
                'Vehicle No',
                'Ewaybill No',
                'Subject',
                'Billing Address',
                'Shipping Address',
            ]);

            foreach ($sales as $sale) {
                $purchaseCost = $sale->items->sum(function ($item) {
                    return ($item->product?->price ?? 0) * $item->quantity;
                });
                $profitLoss = $sale->grand_total - $purchaseCost;

                fputcsv($handle, [
                    $sale->invoice_no,
                    $sale->created_at->format('Y-m-d H:i:s'),
                    $sale->customer_name,
                    number_format($purchaseCost, 2, '.', ''),
                    number_format($sale->grand_total, 2, '.', ''),
                    number_format($sale->gst_amount, 2, '.', ''),
                    number_format($profitLoss, 2, '.', ''),
                    $sale->po_no,
                    $sale->challan_no,
                    $sale->vehicle_no,
                    $sale->ewaybill_no,
                    $sale->subject,
                    $sale->billing_address,
                    $sale->shipping_address,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}