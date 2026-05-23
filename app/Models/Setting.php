<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'brand_name',
        'proprietor_name',
        'company_description',
        'logo',
        'gst_number',
        'pan_number',
        'address',
        'email',
        'phone',
        'default_gst_percent',
        'bank_name',
        'bank_account_no',
        'bank_ifsc',
    ];
}