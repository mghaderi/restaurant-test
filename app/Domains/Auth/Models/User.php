<?php

namespace App\Domains\Auth\Models;

use App\Domains\Order\Models\DelayOrder;
use Database\Factories\Auth\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'type',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'user_id',
            'id'
        );
    }

    public function delayOrder(): HasOne
    {
        return $this->hsOne(
            DelayOrder::class,
            'employee_id',
            'id'
        );
    }

    public function delayReports(): HasMany
    {
        return $this->hsOne(
            DelayOrder::class,
            'employee_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
