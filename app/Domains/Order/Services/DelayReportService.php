<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\DelayReport;
use App\Domains\Order\Models\Order;
use App\Http\Responses\BasicResponse;

class DelayReportService
{

    public const TYPE_WITH_DELAY = 'with_delay';
    public const TYPE_NO_DELAY = 'no_delay';

    private ?DelayReport $model;

    public function __construct(?DelayReport $delayReport = null)
    {
        $this->model  = $delayReport;
    }

    public function types(): array
    {
        return [
            self::TYPE_WITH_DELAY => self::TYPE_WITH_DELAY,
            self::TYPE_NO_DELAY => self::TYPE_NO_DELAY,
        ];
    }

    public function addOrderToDelayReport(Order $order, $withDelay = false): DelayReport
    {
        $delayReport = new DelayReport([
            'order_id' => $order->id,
            'type' => $withDelay ? self::TYPE_WITH_DELAY : self::TYPE_NO_DELAY,
            'trip_id' => $order->trip->id ?? null,
            'extra_time' => $order->extra_time,
            'employee_id' => $order->delayOrder->employee_id ?? null
        ]);
        if ($delayReport->save()) {
            return $delayReport;
        }
        (new BasicResponse())->error('can not save delay report');
    }
}
