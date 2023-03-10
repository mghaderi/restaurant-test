<?php

namespace Database\Factories\Order;

use App\Domains\Auth\Models\User;
use App\Domains\Order\Models\DelayOrder;
use App\Domains\Order\Models\Order;
use App\Domains\Transport\Models\Trip;
use App\Domains\Vendor\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Order\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $vendorIds = Vendor::pluck('id')->toArray();
        return [
            'user_id' => fake()->randomElement($userIds),
            'vendor_id' => fake()->randomElement($vendorIds),
            'delivery_time' => fake()->numberBetween(15, 45),
            'extra_time' => fake()->numberBetween(5, 45),
            'extra_attempts' => fake()->numberBetween(1, 5),
        ];
    }

    public function noReport(int $deliveryTime = 1000): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_time' => $deliveryTime,
            'extra_time' => 0,
            'extra_attempts' => 0,
        ]);
    }

    public function withReport(int $extraTime = 0, int $extraAttempts = 0)
    {
        return $this->state(fn (array $attributes) => [
            'delivery_time' => 0,
            'extra_time' => $extraTime,
            'extra_attempts' => $extraAttempts,
        ]);
    }
}
