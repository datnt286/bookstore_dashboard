<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'combos';
    protected $fillable = ['id', 'name', 'supplier_id', 'price', 'quantity', 'description', 'average_rating', 'slug', 'image'];
    protected $appends = ['image_path', 'total_reviews'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function getImagePathAttribute()
    {
        return env('APP_URL') . "/uploads/combos/{$this->image}";
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews->count();
    }
}
