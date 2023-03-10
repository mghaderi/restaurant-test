<?php

namespace App\Domains\Order\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Transport\Models\Trip;
use Database\Factories\Order\DelayOrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelayReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'employee_id',
        'trip_id',
        'extra_time',
        'type',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id',
            'fk-delay_reports-order_id'
        );
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'employee_id',
            'id',
            'fk-delay_reports-employee_id'
        );
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(
            Trip::class,
            'trip_id',
            'id',
            'fk-delay_reports-trip_id'
        );
    }

    protected static function newFactory()
    {
        return DelayOrderFactory::new();
    }
}
