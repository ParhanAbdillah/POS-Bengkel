<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'status'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
