<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'category',
        'main_category',
        'brand',
        'unit',
        'applied_gst',
        'price',
        'stock_level',
        'rating',
        'status',
    ];
}