<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = ['book_id', 'name'];
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return env('APP_URL') . "/uploads/images/{$this->name}";
    }
}
