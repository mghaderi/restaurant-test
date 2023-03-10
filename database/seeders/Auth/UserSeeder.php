<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(100)->customer()->create();
        User::factory(5)->employee()->create();
    }
}
