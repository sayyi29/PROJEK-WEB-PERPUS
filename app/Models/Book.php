<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'author',
        'publisher',
        'year',
        'stock',
        'category_id',
        'cover_image',
        'description',
        'genre',
        'synopsis'
    ];

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return str_starts_with($this->cover_image, 'http') 
                ? $this->cover_image 
                : asset('storage/' . $this->cover_image);
        }

        // Return a professional placeholder based on the title
        return "https://ui-avatars.com/api/?name=" . urlencode($this->title) . "&size=512&background=f1f5f9&color=64748b&bold=true&format=svg";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
}
