<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\DelayOrder;

class DelayOrderService
{

    public const STATUS_NOT_ASSIGNED = 'not_assigned';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';

    private ?DelayOrder $model;

    public function __construct(?DelayOrder $delayOrder = null)
    {
        $this->model  = $delayOrder;
    }

    public function statuses(): array
    {
        return [
            self::STATUS_NOT_ASSIGNED => self::STATUS_NOT_ASSIGNED,
            self::STATUS_IN_PROGRESS => self::STATUS_IN_PROGRESS,
            self::STATUS_DONE => self::STATUS_DONE,
        ];
    }
}
