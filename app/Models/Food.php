<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;

class Food extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'price', 'is_active', 'description', 'category_id', 'image'];
    protected $with = ['category'];
    public $table = 'foods';
    protected $appends = ['image_url'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return image url for this model.
     */
    public function getImageUrlAttribute()
    {
        return ($this->image === "") ? "" : url('images', $this->image);
    }
}
