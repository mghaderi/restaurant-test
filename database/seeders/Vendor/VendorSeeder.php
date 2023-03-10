<?php

namespace Database\Seeders\Vendor;

use App\Domains\Vendor\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        Vendor::factory(10)->create();
    }
}
