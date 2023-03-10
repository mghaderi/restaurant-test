<?php

namespace App\Domains\Order\Http\Controllers;

use App\Domains\Order\Http\Requests\DelayRequest;
use App\Domains\Order\Services\DelayOrderService;
use App\Domains\Order\Services\DelayReportService;
use App\Domains\Order\Services\OrderService;
use App\Http\Responses\BasicResponse;

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
        if ($orderService->checkForDelay()) {
            $delayReportService->addOrderToDelayReport($orderService->fetch(), true);
            $delayOrderService->addOrderToDelayOrder($orderService->fetch());
        } elseif ($orderService->checkForReport()) {
            $delayReportService->addOrderToDelayReport($orderService->fetch(), false);
            $orderService->extendDeliveryTime();
        }
        $orderService = new OrderService($request->input('order_id'));
        return (new BasicResponse)->ok($orderService->fetchData());
    }
}
