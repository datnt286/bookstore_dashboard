<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    protected $table = 'customers';
    protected $fillable = ['id', 'username', 'password', 'name', 'phone', 'email', 'address', 'avatar', 'status'];
    protected $appends = ['avatar_image'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarImageAttribute()
    {
        return env('APP_URL') . "/uploads/customers/{$this->avatar}";
    }
}
