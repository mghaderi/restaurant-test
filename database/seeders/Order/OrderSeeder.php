<?php

namespace Database\Seeders\Order;

use App\Domains\Order\Models\Order;
use App\Domains\Transport\Models\Trip;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $this->noReportNoTrip();
        $this->noReportWithTrip();
        $this->withReportNoTripWithDelay();
        $this->withReportWithTripNoDelay();
        $this->withReportWithTripWithDelay();
    }

    public function noReportNoTrip()
    {
        Order::factory(5)->noReport()->create();
    }

    public function noReportWithTrip()
    {
        $orders = Order::factory(5)->noReport()->create();
        foreach ($orders as $order) {
            Trip::factory()->create(['order_id' => $order->id]);
        }
    }

    public function withReportNoTripWithDelay()
    {
        Order::factory(5)->withReport()->create();
    }

    public function withReportWithTripNoDelay()
    {
        $orders = Order::factory(5)->withReport()->create();
        foreach ($orders as $order) {
            Trip::factory()->canNotHaveOrderInDelayOrderStatus()->create(['order_id' => $order->id]);
        }
    }

    public function withReportWithTripWithDelay()
    {
        $orders = Order::factory(5)->withReport()->create();
        foreach ($orders as $order) {
            Trip::factory()->canHaveOrderInDeleyOrderStatus()->create(['order_id' => $order->id]);
        }
    }
}
