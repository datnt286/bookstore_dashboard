<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = ['order_id', 'book_id', 'combo_id', 'price', 'quantity'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
