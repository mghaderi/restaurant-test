<?php

namespace Tests\Unit\Auth\Services;

use App\Domains\Auth\Services\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /** @test */
    public function test_user_types(): void
    {
        $userService = new UserService();
        $userTypes = $userService->types();
        $this->assertTrue(count($userTypes) == 2);
        $this->assertArrayHasKey('employee', $userTypes);
        $this->assertArrayHasKey('customer', $userTypes);
        $this->assertTrue($userTypes['employee'] === 'employee');
        $this->assertTrue($userTypes['customer'] === 'customer');
    }
}
