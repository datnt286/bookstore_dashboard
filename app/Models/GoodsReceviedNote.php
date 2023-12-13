<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceviedNote extends Model
{
    use HasFactory;
    protected $table = 'goods_recevied_notes';
    protected $fillable = ['supplier_id', 'admin_id', 'total', 'note', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
