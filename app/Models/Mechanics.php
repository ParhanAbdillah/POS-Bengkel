<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanics extends Model
{
    protected $fillable = [
        'name_mechanic',
        'phone_mechanic',
        'address_mechanic',
        'status_mechanic',
    ];
}
