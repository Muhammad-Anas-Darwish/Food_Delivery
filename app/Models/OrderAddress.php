<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    public $fillable = ['address_line', 'mobile_phone', 'city_id', 'user_id'];
    public $table = 'orders_addresses';
}
