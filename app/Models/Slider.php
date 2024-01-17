<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
    protected $fillable = ['id', 'name', 'book_id', 'image', 'status'];
    protected $appends = ['book_name'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getBookNameAttribute()
    {
        return $this->book->name;
    }
}
