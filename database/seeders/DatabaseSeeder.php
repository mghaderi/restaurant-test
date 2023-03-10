<?php

namespace Database\Seeders;

use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Order\OrderSeeder;
use Database\Seeders\Transport\TransporterSeeder;
use Database\Seeders\Vendor\VendorSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(TransporterSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
