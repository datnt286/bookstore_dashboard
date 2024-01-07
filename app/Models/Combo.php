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
    protected $fillable = ['id', 'name', 'supplier_id', 'price', 'quantity', 'description', 'slug', 'image'];
    protected $appends = ['absolute_path'];

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
        return $this->hasManyThrough(Review::class, OrderDetail::class);
    }

    public function getAbsolutePathAttribute()
    {
        return env('APP_URL') . "/uploads/combos/{$this->image}";
    }
}
