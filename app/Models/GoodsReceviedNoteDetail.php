<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceviedNoteDetail extends Model
{
    use HasFactory;
    protected $table = 'goods_recevied_note_details';
    protected $fillable = ['goods_recevied_note_id', 'book_id', 'combo_id', 'import_price', 'price', 'quantity'];
    protected $appends = ['product_name', 'product_image'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
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
}
