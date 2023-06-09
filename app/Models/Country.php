<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public $fillable = ['title'];

    public function cities()
    {
        return $this->belongsTo(City::class, 'id');
    }
}
