<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'been_ordered'];
    public $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The foods that belong to the cart.
     */
    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'foods_carts')->withPivot('quantity');
    }

    /**
     * Total price of all foods in cart
     */
    public function total(): int
    {
        $total = 0;
        $foods = $this->foods;

        foreach ($foods as $food) {
            $total += $food->price * $food->pivot->quantity;
        }

        return $total;
    }
}
