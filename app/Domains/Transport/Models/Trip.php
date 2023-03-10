<?php

namespace App\Domains\Transport\Models;

use Database\Factories\Transport\TripFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'transporter_id',
        'order_id',
        'status',
    ];

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(
            Transporter::class,
            'transporter_id',
            'id',
            'fk-trips-transporter_id'
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id',
            'fk-trips-order_id'
        );
    }

    public function delayOrder(): HasOne
    {
        return $this->hsOne(
            DelayOrder::class,
            'trip_id',
            'id'
        );
    }

    public function delayReports(): HasMany
    {
        return $this->hsOne(
            DelayReport::class,
            'trip_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return TripFactory::new();
    }
}
