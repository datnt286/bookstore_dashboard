<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['customer_id', 'admin_id', 'name', 'phone', 'address', 'total', 'shipping_fee', 'total_payment', 'note', 'status'];
    protected $appends = ['order_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getOrderDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
