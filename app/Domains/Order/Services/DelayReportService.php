<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\DelayReport;
use App\Domains\Order\Models\Order;
use App\Http\Responses\BasicResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function badVendorsInLastWeek()
    {
        return DB::table('delay_reports')
            ->select(DB::raw('COUNT(*) as number'), 'orders.vendor_id', 'vendors.name')
            ->join('orders', 'delay_reports.order_id', '=', 'orders.id')
            ->join('vendors', 'vendors.id', '=', 'orders.vendor_id')
            ->whereBetween('orders.created_at', [now()->startOfWeek(Carbon::SATURDAY)->format('Y-m-d') . " 00:00:00", now()->format('Y-m-d') . " 23:59:59"])
            ->groupBy('orders.vendor_id')
            ->orderBy('number', 'desc')
            ->get()->toArray();
    }
}
