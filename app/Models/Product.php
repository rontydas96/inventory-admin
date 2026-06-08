<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'material_code',
        'name',
        'hsn_code',
        'category',
        'main_category',
        'brand',
        'unit',
        'gst_percentage',
        'price',
        'selling_price',
        'stock_level',
        'rating',
        'status',
        'purchase_invoice_no',
        'purchase_invoice_date',
        'remarks',
    ];

    protected $appends = [
        'effective_price',
    ];

    protected $casts = [
        'purchase_invoice_date' => 'date',
    ];

    public function getEffectivePriceAttribute()
    {
        return $this->selling_price ?? $this->price;
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
