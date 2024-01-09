<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'comments';
    protected $fillable = ['customer_id', 'book_id', 'combo_id', 'parent_id', 'content'];
    protected $appends = ['customer_name', 'product_name', 'comment_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function replys()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
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

    public function getCommentDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
