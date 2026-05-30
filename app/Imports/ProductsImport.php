<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        // Header is on row 2
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $materialId = trim((string) ($row['material_code'] ?? ''));
            $name = trim((string) ($row['description_of_material'] ?? ''));

            // Skip invalid rows
            if ($materialId === '' || $name === '') {
                continue;
            }

            // GST may come as "18%" or "18"
            $gst = $row['gst_percentage'] ?? $row['applied_gst'] ?? null;

            if (is_string($gst)) {
                $gst = str_replace('%', '', trim($gst));
            }

            $stock = (int) ($row['available_quantity'] ?? 0);

            // Try to parse invoice/purchase date from common headers
            $invoiceDateRaw = $row['purchase_invoice_date'] ?? $row['invoice_date'] ?? $row['purchase_date'] ?? null;
            $invoiceDate = null;

            if ($invoiceDateRaw) {
                $ts = strtotime(trim((string) $invoiceDateRaw));
                if ($ts !== false) {
                    $invoiceDate = date('Y-m-d', $ts);
                }
            }

            Product::updateOrCreate(
                [
                    'material_code' => $materialId,
                ],
                [
                    'name' => $name,
                    'hsn_code' => $row['hsn_code'] ?? null,
                    'main_category' => $row['main_category'] ?? null,
                    'category' => $row['sub_category'] ?? null,
                    'brand' => null, // Optional; editable later
                    'unit' => $row['unit'] ?? null,
                    'gst_percentage' => is_numeric($gst) ? (float) $gst : null,
                    'price' => (float) ($row['costin_rs_inclusive_of_gst'] ?? 0),
                    'selling_price' => (float) ($row['selling_price'] ?? 0),
                    'stock_level' => $stock,
                    'rating' => 5.0, // Default
                    'status' => $stock > 0 ? 'Active' : 'Out of Stock',
                    'purchase_invoice_date' => $invoiceDate,
                ]
            );
        }
    }
}