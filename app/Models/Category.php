<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories';
    protected $fillable = ['id', 'name', 'image', 'slug'];
    protected $appends = ['absolute_path'];

    public function getAbsolutePathAttribute()
    {
        return env('APP_URL') . "/uploads/categories/{$this->image}";
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
