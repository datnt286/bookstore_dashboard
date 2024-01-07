<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = ['order_id', 'book_id', 'combo_id', 'price', 'quantity'];
    protected $appends = ['product_name', 'product_image', 'product_slug'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getProductNameAttribute()
    {
        if ($this->book_id) {
            return $this->book->name;
        } else if ($this->combo_id) {
            return $this->combo->name;
        }

        return 'Không có sản phẩm';
    }

    public function getProductImageAttribute()
    {
        if ($this->book_id) {
            return $this->book->images->first()->absolute_path;
        } elseif ($this->combo_id) {
            return $this->combo->absolute_path;
        }

        return null;
    }

    public function getProductSlugAttribute()
    {
        if ($this->book_id) {
            return $this->book->slug;
        } else if ($this->combo_id) {
            return $this->combo->slug;
        }

        return 'Không có sản phẩm';
    }
}
