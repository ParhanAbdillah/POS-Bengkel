<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSaleDetail extends Model
{
    protected $fillable = [
        'product_sale_id', 'sparepart_id', 'quantity', 'price', 'subtotal'
    ];

    public function productSale()
    {
        return $this->belongsTo(ProductSale::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
