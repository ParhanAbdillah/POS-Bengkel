<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = [
        'category_id',
        'sku',
        'name_sparepart',
        'brand_sparepart',
        'stock_sparepart',
        'min_stock_sparepart',
        'purchase_price',
        'selling_price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
