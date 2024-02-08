<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GoodsReceviedNote extends Model
{
    use HasFactory;
    protected $table = 'goods_recevied_notes';
    protected $fillable = ['supplier_id', 'admin_id', 'total', 'note', 'status'];
    protected $appends = ['create_date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getCreateDateAttribute()
    {
        $timestamp = $this->attributes['updated_at'] ?? $this->attributes['created_at'];

        return Carbon::parse($timestamp)
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
