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
        'challan_no',
        'vehicle_no',
        'ewaybill_no',
        'subject',

        // Totals
        'subtotal',
        'gst_amount',
        'grand_total',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}