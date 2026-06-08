<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanics::class, 'mechanic_id');
    }

    public function detailServices()
    {
        return $this->hasMany(TransactionDetailService::class);
    }

    public function detailSpareparts()
    {
        return $this->hasMany(TransactionDetailSparepart::class);
    }
}
