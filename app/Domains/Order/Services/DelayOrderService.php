<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\DelayOrder;
use App\Domains\Order\Models\Order;
use App\Http\Responses\BasicResponse;
use Carbon\Carbon;

class DelayOrderService
{

    public const STATUS_NOT_ASSIGNED = 'not_assigned';
    public const STATUS_IN_PROGRESS = 'in_progress';

    private ?DelayOrder $model;

    public function __construct(?DelayOrder $delayOrder = null)
    {
        $this->model  = $delayOrder;
    }

    public function statuses(): array
    {
        return [
            self::STATUS_NOT_ASSIGNED => self::STATUS_NOT_ASSIGNED,
            self::STATUS_IN_PROGRESS => self::STATUS_IN_PROGRESS
        ];
    }

    public function alreadyInDelay(Order $order)
    {
        $status = $order->delayOrder->status ?? '';
        if (!empty($status)) {
            return true;
        }
        return false;
    }

    public function fetchData(): array
    {
        if (empty($this->model)) {
            return [];
        }
        if (empty($this->model->employee_id)) {
            return [
                'status' => $this->model->status,
            ];
        }
        return [
            'status' => $this->model->status,
            'employee_id' => $this->model->employee_id,
        ];
    }

    public function addOrderToDelayOrder(Order $order): DelayOrder
    {
        $delayOrder = new DelayOrder([
            'order_id' => $order->id,
            'trip_id' => $order->trip->id ?? null,
            'status' => self::STATUS_NOT_ASSIGNED,
        ]);
        if ($delayOrder->save()) {
            return $delayOrder;
        }
        (new BasicResponse)->error('can not save delay order');
    }
}
