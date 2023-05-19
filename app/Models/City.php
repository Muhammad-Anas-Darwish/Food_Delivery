<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $with = ['country'];
    public $fillable = ['title', 'country_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
        // return $this->belongsTo(Country::class, 'country_id');
    }
}
