<?php

namespace Tests\Unit\Order\Services;

use PHPUnit\Framework\TestCase;
use App\Domains\Order\Services\DelayOrderService;

class DelayOrderServiceTest extends TestCase
{
    /** @test */
    public function test_delay_order_statuses(): void
    {
        $statuses = (new DelayOrderService())->statuses();
        $this->assertTrue(count($statuses) == 3);
        foreach ($statuses as $key => $value) {
            $this->assertTrue(in_array($key, [
                DelayOrderService::STATUS_NOT_ASSIGNED,
                DelayOrderService::STATUS_IN_PROGRESS,
                DelayOrderService::STATUS_DONE,
            ]));
            $this->assertTrue(in_array($value, [
                DelayOrderService::STATUS_NOT_ASSIGNED,
                DelayOrderService::STATUS_IN_PROGRESS,
                DelayOrderService::STATUS_DONE,
            ]));
        }
    }
}
