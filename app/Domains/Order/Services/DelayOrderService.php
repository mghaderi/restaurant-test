<?php

namespace App\Domains\Order\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
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

    public function validationForAssignOrderToEmployee(Order $order, User $employee): DelayOrder
    {
        $delayOrder = DelayOrder::where('order_id', $order->id)
            ->first();
        if (empty($delayOrder)) {
            (new BasicResponse())->notFoundError('can not found order in delay.');
        }
        if (!empty($delayOrder->employee_id)) {
            (new BasicResponse())->validationError('order already assigned to employee id ' . $delayOrder->employee_id);
        }
        $employeeDelayOrder = DelayOrder::where('employee_id', $employee->id)
            ->first();
        if (!empty($employeeDelayOrder)) {
            (new BasicResponse())->validationError('employee is busy with order id ' . $employeeDelayOrder->order_id);
        }
        return $delayOrder;
    }

    public function assignOrderToEmployee(Order $order, User $employee): DelayOrder
    {
        $delayOrder = $this->validationForAssignOrderToEmployee($order, $employee);
        $delayOrder->employee_id = $employee->id;
        $delayOrder->status = self::STATUS_IN_PROGRESS;
        if ($delayOrder->save()) {
            return $delayOrder;
        }
        (new BasicResponse)->error('can not save delay for order');
    }
}
