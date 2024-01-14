<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = ['customer_id', 'book_id', 'combo_id', 'rating', 'average', 'content'];
    protected $appends = ['review_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function getReviewDateAttribute()
    {
        $timestamp = $this->attributes['updated_at'] ?? $this->attributes['created_at'];

        return Carbon::parse($timestamp)
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
