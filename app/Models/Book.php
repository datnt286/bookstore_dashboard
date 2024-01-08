<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'books';
    protected $fillable = ['name', 'category_id', 'publisher_id', 'supplier_id', 'size', 'weight', 'num_pages', 'language', 'release_date', 'price', 'e_book_price', 'quantity', 'is_combo', 'combo_id', 'description', 'slug'];
    protected $appends = ['category_name', 'category_slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function combos()
    {
        return $this->belongsToMany(Combo::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, OrderDetail::class)->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getCategorySlugAttribute()
    {
        return $this->category->slug;
    }
}
