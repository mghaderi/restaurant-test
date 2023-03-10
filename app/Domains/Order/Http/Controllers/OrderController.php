<?php

namespace App\Domains\Order\Http\Controllers;

use App\Domains\Auth\Services\UserService;
use App\Domains\Order\Http\Requests\AssignRequest;
use App\Domains\Order\Http\Requests\DelayRequest;
use App\Domains\Order\Services\DelayOrderService;
use App\Domains\Order\Services\DelayReportService;
use App\Domains\Order\Services\OrderService;
use App\Http\Responses\BasicResponse;
use Illuminate\Support\Facades\DB;

class OrderController
{
    public function delay(DelayRequest $request)
    {
        $orderService = new OrderService($request->input('order_id'));
        $delayReportService = new DelayReportService();
        $delayOrderService = new DelayOrderService();
        if ($delayOrderService->alreadyInDelay($orderService->fetch())) {
            $orderData = $orderService->fetchData();
            return (new BasicResponse)->ok($orderData);
        }
        DB::beginTransaction();
        if ($orderService->checkForDelay()) {
            $delayReportService->addOrderToDelayReport($orderService->fetch(), true);
            $delayOrderService->addOrderToDelayOrder($orderService->fetch());
        } elseif ($orderService->checkForReport()) {
            $orderService->extendDeliveryTime();
            $delayReportService->addOrderToDelayReport($orderService->fetch(), false);
        }
        DB::commit();
        $orderService = new OrderService($request->input('order_id'));
        return (new BasicResponse)->ok($orderService->fetchData());
    }

    public function assign(AssignRequest $request)
    {
        $delayOrderService = new DelayOrderService();
        $delayOrder = $delayOrderService->assignOrderToEmployee(
            (new UserService())->fetchEmployee($request->input('employee_id'))
        );
        $orderService = new OrderService($delayOrder->order_id);
        return (new BasicResponse)->ok($orderService->fetchData());
    }

    public function resolve(AssignRequest $request)
    {
        $orderService = new DelayOrderService();
        DB::beginTransaction();
        $order = $orderService->resolveOrderWithEmployee(
            (new UserService())->fetchEmployee($request->input('employee_id'))
        );
        DB::commit();
        $orderService = new OrderService($order->id);
        return (new BasicResponse)->ok($orderService->fetchData());
    }
}
