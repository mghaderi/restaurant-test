<?php

namespace Database\Factories\Transport;

use App\Domains\Order\Models\Order;
use App\Domains\Transport\Models\Transporter;
use App\Domains\Transport\Models\Trip;
use App\Domains\Transport\Services\TripService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Transport\Models\Trip>
 */
class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $transporterIds = Transporter::pluck('id')->toArray();
        $orderIds = Order::pluck('id')->toArray();
        return [
            'transporter_id' => fake()->randomElement($transporterIds),
            'order_id' => fake()->unique()->randomElement($orderIds),
            'status' => fake()->randomElement((new TripService())->statuses()),
        ];
    }

    public function canHaveOrderInDeleyOrderStatus(?string $status = null): static
    {
        $tripService = new TripService();
        if (empty($status)) {
            $status = fake()->randomElement($tripService->canHaveOrderInDeleyOrderStatuses());
        } else {
            $status = $tripService->canHaveOrderInDeleyOrderStatuses()[$status];
        }
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    public function canNotHaveOrderInDelayOrderStatus(?string $status = null): static
    {
        $tripService = new TripService();
        if (empty($status)) {
            $status = fake()->randomElement($tripService->canNotHaveOrderInDelayOrderStatuses());
        } else {
            $status = $tripService->canNotHaveOrderInDelayOrderStatuses()[$status];
        }
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

}
