<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    protected $fillable = [
        'invoice_number', 'customer_name', 'customer_phone', 
        'grand_total', 'payment_method', 'money_paid', 'money_change'
    ];

    public function details()
    {
        return $this->hasMany(ProductSaleDetail::class);
    }
}
