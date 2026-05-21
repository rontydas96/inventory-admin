<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->toDateString());

        $sales = Sale::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->latest()
            ->get();

        $invoiceCount = $sales->count();
        $totalRevenue = $sales->sum('grand_total');
        $totalTax = $sales->sum('gst_amount');

        $lowStockProducts = Product::where('stock_level', '<=', 10)
            ->where('status', 'Active')
            ->orderBy('stock_level')
            ->get();

        return view('reports.index', compact(
            'from',
            'to',
            'sales',
            'invoiceCount',
            'totalRevenue',
            'totalTax',
            'lowStockProducts'
        ));
    }

    public function exportSalesCsv(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->toDateString());

        $sales = Sale::whereDate('created_at', '>=', $from)
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
                'Subtotal',
                'GST',
                'Grand Total',
            ]);

            foreach ($sales as $sale) {
                fputcsv($handle, [
                    $sale->invoice_no,
                    $sale->created_at->format('Y-m-d H:i:s'),
                    $sale->customer_name,
                    $sale->subtotal,
                    $sale->gst_amount,
                    $sale->grand_total,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}