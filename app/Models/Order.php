<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['customer_id', 'admin_id', 'name', 'phone', 'address', 'total', 'shipping_fee', 'total_payment', 'note', 'status'];
    protected $appends = ['customer_name'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
    }
}
