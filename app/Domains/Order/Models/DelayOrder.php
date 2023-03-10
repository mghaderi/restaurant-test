<?php

namespace App\Domains\Order\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Vendor\Models\Vendor;
use Database\Factories\Order\DelayOrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DelayOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'employee_id',
        'trip_id',
        'status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id',
            'fk-delay_orders-order_id'
        );
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'employee_id',
            'id',
            'fk-delay_orders-employee_id'
        );
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(
            Trip::class,
            'trip_id',
            'id',
            'fk-delay_orders-trip_id'
        );
    }

    protected static function newFactory()
    {
        return DelayOrderFactory::new();
    }
}
