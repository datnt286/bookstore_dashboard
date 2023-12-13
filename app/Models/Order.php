<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['customer_id', 'phone', 'address', 'total', 'shipping_fee', 'total_payment', 'note', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
