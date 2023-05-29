<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodCart extends Model
{
    use HasFactory;
    public $table = 'foods_carts';

    public $fillable = ['cart_id', 'food_id', 'quantity'];
    public $with = ['food'];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
