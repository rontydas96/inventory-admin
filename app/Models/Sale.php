<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no',

        'customer_name',
        'billing_address',
        'shipping_address',
        'customer_gst',
        'customer_pan',
        'customer_phone',
        'customer_email',

        // New invoice fields
        'po_no',
        'po_date',
        'supplier_code',
        'ref_memo_no',
        'sale_date',
        'challan_no',
        'vehicle_no',
        'ewaybill_no',
        'subject',

        // Totals
        'subtotal',
        'gst_amount',
        'grand_total',

        // Payment metadata
        'payment_status',
        'payment_remarks',
    ];

    protected $casts = [
        'po_date' => 'date',
        'sale_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}