<?php

namespace App\Domains\Transport\Services;

use App\Domains\Transport\Models\Trip;

class TripService
{

    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_AT_VENDOR = 'at_vendor';
    public const STATUS_PICKED = 'picked';
    public const STATUS_DELIVERED = 'delivered';

    private ?Trip $model;

    public function __construct(?Trip $trip = null)
    {
        $this->model  = $trip;
    }

    public function statuses(): array
    {
        return [
            self::STATUS_ASSIGNED => self::STATUS_ASSIGNED,
            self::STATUS_AT_VENDOR => self::STATUS_AT_VENDOR,
            self::STATUS_PICKED => self::STATUS_PICKED,
            self::STATUS_DELIVERED => self::STATUS_DELIVERED,
        ];
    }

    public function canHaveOrderInDeleyOrderStatuses(): array
    {
        return [
            self::STATUS_DELIVERED => self::STATUS_DELIVERED,
        ];
    }

    public function canNotHaveOrderInDelayOrderStatuses(): array
    {
        return [
            self::STATUS_ASSIGNED => self::STATUS_ASSIGNED,
            self::STATUS_AT_VENDOR => self::STATUS_AT_VENDOR,
            self::STATUS_PICKED => self::STATUS_PICKED
        ];
    }
}
