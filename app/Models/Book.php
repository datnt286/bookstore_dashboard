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
    protected $fillable = ['name', 'category_id', 'publisher_id', 'supplier_id', 'size', 'weight', 'num_pages', 'language', 'release_date', 'price', 'e_book_price', 'quantity', 'description', 'average_rating', 'slug'];
    protected $appends = ['image', 'image_path', 'category_name', 'publisher_name', 'supplier_name', 'category_slug', 'total_reviews', 'total_quantity_sold_this_month'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

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

    public function combos()
    {
        return $this->belongsToMany(Combo::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function successful_order_details_this_month()
    {
        return $this->hasMany(OrderDetail::class)->whereHas('order', function ($query) {
            $query->where('status', 4)
                ->whereMonth('created_at', now()->month);
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function getImageAttribute()
    {
        $image = $this->images->first();

        return $image ? $image->name : 'default-image.jpg';
    }

    public function getImagePathAttribute()
    {
        $image = $this->images->first();

        $imagePath = $image?->name ?? 'default-image.jpg';

        return env('APP_URL') . "/uploads/images/" . $imagePath;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getPublisherNameAttribute()
    {
        return $this->publisher->name;
    }

    public function getSupplierNameAttribute()
    {
        return $this->supplier->name;
    }

    public function getCategorySlugAttribute()
    {
        return $this->category->slug;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews->count();
    }

    public function getTotalQuantitySoldThisMonthAttribute()
    {
        return $this->successful_order_details_this_month()->sum('quantity');
    }
}
