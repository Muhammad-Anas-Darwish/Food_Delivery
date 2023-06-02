<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    public $table = 'orders';

    public $with = ['cart', 'address'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(OrderAddress::class);
    }
}
