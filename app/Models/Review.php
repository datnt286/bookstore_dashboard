<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = ['customer_id', 'order_detail_id', 'rating', 'average', 'content'];
    protected $appends = ['review_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getReviewDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
