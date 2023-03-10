<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\Order;
use App\Domains\Transport\Services\TripService;
use App\Http\Responses\BasicResponse;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class OrderService
{
    private ?Order $model;

    public function __construct(int $orderId)
    {
        $order = Order::where('id', $orderId)->first();
        if (!$order instanceof Order) {
            (new BasicResponse)->notFoundError('order not found.');
        }
        $this->model = $order;
    }

    public function fetch()
    {
        return $this->model;
    }

    public function deliveryTimeInCarbon(): Carbon
    {
        $minutes = empty($this->model->delivery_time) ? 0 : $this->model->delivery_time;
        $extraMinutes = empty($this->model->extra_time) ? 0 : $this->model->extra_time;
        $deliveryTime = $this->model->created_at;
        $deliveryTime = $deliveryTime->addMinutes($minutes + $extraMinutes);
        return $deliveryTime;
    }

    public function checkForReport(): bool
    {
        if (now() > $this->deliveryTimeInCarbon()) {
            return true;
        }
        return false;
    }

    public function checkForDelay(): bool
    {
        if ($this->checkForReport()) {
            $tripService = new TripService($this->model->trip);
            if ($tripService->checkForDelay()) {
                return true;
            }
        }
        return false;
    }

    public function fetchData() {
        $response = [
            'order_id' => $this->model->id,
            'delivery_time' => $this->deliveryTimeInCarbon()->format('Y/m/d H:i')
        ];
        $tripService = new TripService($this->model->trip);
        $tripData = $tripService->fetchData();
        if (!empty($tripData)) {
            $response['trip'] = $tripData;
        }
        $delayOrderService = new DelayOrderService($this->model->delayOrder);
        $delayOrderData = $delayOrderService->fetchData();
        if (!empty($delayOrderData)) {
            $response['delay'] = $delayOrderData;
        }
        return $response;
    }

    public function extendDeliveryTime(): Order
    {
        $response = Http::get('https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7')->json();
        $extraMinutes = $response['data']['eta'] ?? '';
        if ($extraMinutes === '') {
            (new BasicResponse())->error('can not get extra time');
        }
        $difference = now()->diffInMinutes($this->deliveryTimeInCarbon());
        $this->model->extra_time = empty($this->model->extra_time) ? 0 : $this->model->extra_time;
        $this->model->extra_time = $this->model->extra_time + $difference + (int)$extraMinutes;
        $this->model->extra_attempts = empty($this->model->extra_attempts) ? 0 : $this->model->extra_attempts;
        $this->model->extra_attempts  = $this->model->extra_attempts + 1;
        if ($this->model->save()) {
            return $this->model;
        }
        (new BasicResponse())->error('can not extend time in order');
    }
}
