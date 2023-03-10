<?php

namespace Database\Factories\Vendor;

use App\Domains\Vendor\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Vendor\Models\Vendor>
 */
class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'address' => fake()->address(),
            'postal_code' => fake()->numerify('##########'),
            'number' => fake()->numerify('09#########'),
        ];
    }
}
