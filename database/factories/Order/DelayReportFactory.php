<?php

namespace Database\Factories\Order;

use App\Domains\Order\Models\DelayOrder;
use App\Domains\Vendor\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Order\Models\DelayReport>
 */
class DelayReportFactory extends Factory
{
    protected $model = DelayReport::class;

    public function definition(): array
    {
        return [
            'order_id' => null,
            'employee_id' => null,
            'trip_id' => null,
            'extra_time' => null,
            'type' => null,
        ];
    }

}
