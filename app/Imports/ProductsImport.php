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
            $productId = trim((string) ($row['material_code'] ?? ''));
            $name = trim((string) ($row['description_of_material'] ?? ''));

            // Skip invalid rows
            if ($productId === '' || $name === '') {
                continue;
            }

            // GST may come as "18%" or "18"
            $gst = $row['applied_gst'] ?? null;

            if (is_string($gst)) {
                $gst = str_replace('%', '', trim($gst));
            }

            $stock = (int) ($row['available_quantity'] ?? 0);

            Product::updateOrCreate(
                [
                    'product_id' => $productId,
                ],
                [
                    'name' => $name,
                    'main_category' => $row['main_category'] ?? null,
                    'category' => $row['sub_category'] ?? null,
                    'brand' => null, // Optional; editable later
                    'unit' => $row['unit'] ?? null,
                    'applied_gst' => is_numeric($gst) ? (float) $gst : null,
                    'price' => (float) ($row['costin_rs_inclusive_of_gst'] ?? 0),
                    'stock_level' => $stock,
                    'rating' => 5.0, // Default
                    'status' => $stock > 0 ? 'Active' : 'Out of Stock',
                ]
            );
        }
    }
}