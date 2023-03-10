<?php

namespace Database\Seeders\Transport;

use App\Domains\Transport\Models\Transporter;
use Illuminate\Database\Seeder;

class TransporterSeeder extends Seeder
{
    public function run(): void
    {
        Transporter::factory(5)->create();
    }
}
