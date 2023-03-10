<?php

namespace App\Domains\Order\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Vendor\Models\Vendor;
use Database\Factories\Order\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'delivery_time',
        'extra_time',
        'extra_attempts',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(
            Vendor::class,
            'vendor_id',
            'id',
            'fk-orders-vendor_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id',
            'fk-orders-user_id'
        );
    }

    public function trip(): HasOne
    {
        return $this->hasOne(
            Trip::class,
            'order_id',
            'id'
        );
    }

    public function delayOrder(): HasOne
    {
        return $this->hasOne(
            DelayOrder::class,
            'order_id',
            'id'
        );
    }

    public function delayReports(): HasMany
    {
        return $this->hasMany(
            DelayReport::class,
            'order_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}
