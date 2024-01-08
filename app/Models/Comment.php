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
    protected $appends = ['comment_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function replys()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function getCommentDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('d/m/Y H:i');
    }
}
