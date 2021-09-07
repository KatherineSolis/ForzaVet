<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'suppliers_id',
        'category_id',
        'name',
        'buy_price',
        'sale_price',
        'units',
        'stock',
        'expiry_date',
        'image'
    ];
}
