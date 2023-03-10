<?php

namespace Database\Factories\Transport;

use App\Domains\Transport\Models\Transporter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Transport\Models\Transporter>
 */
class TransporterFactory extends Factory
{
    protected $model = Transporter::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'family' => fake()->name(),
            'national_code' => fake()->unique()->numerify('##########'),
            'number' => fake()->numerify('09#########'),
        ];
    }
}
