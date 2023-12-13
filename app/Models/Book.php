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
}
