<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'purchase_invoice_no',
        'purchase_invoice_pdf',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'purchase_invoice_no', 'purchase_invoice_no');
    }

    public function getProductCodesAttribute()
    {
        return $this->products->pluck('material_code')->filter()->unique()->values()->join(', ');
    }
}
