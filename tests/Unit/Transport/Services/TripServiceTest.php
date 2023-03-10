<?php

namespace Tests\Unit\Transport\Services;

use App\Domains\Transport\Services\TripService;
use PHPUnit\Framework\TestCase;

class TripServiceTest extends TestCase
{
    /** @test */
    public function test_trip_statuses(): void
    {
        $tripService = new TripService();
        $tripStatuses = $tripService->statuses();
        $this->assertTrue(count($tripStatuses) == 4);
        foreach ($tripStatuses as $key => $value) {
            $this->assertTrue(in_array($key, [
                TripService::STATUS_ASSIGNED,
                TripService::STATUS_AT_VENDOR,
                TripService::STATUS_PICKED,
                TripService::STATUS_DELIVERED,
            ]));
            $this->assertTrue(in_array($value, [
                TripService::STATUS_ASSIGNED,
                TripService::STATUS_AT_VENDOR,
                TripService::STATUS_PICKED,
                TripService::STATUS_DELIVERED,
            ]));
        }
    }

    /** @test */
    public function test_can_have_order_in_delay_order_statuses(): void
    {
        $tripService = new TripService();
        $tripStatuses = $tripService->canHaveOrderInDeleyOrderStatuses();
        $this->assertTrue(count($tripStatuses) == 1);
        foreach ($tripStatuses as $key => $value) {
            $this->assertTrue(in_array($key, [
                TripService::STATUS_DELIVERED,
            ]));
            $this->assertTrue(in_array($value, [
                TripService::STATUS_DELIVERED,
            ]));
        }
    }

    /** @test */
    public function test_can_not_have_order_in_delay_order_statuses(): void
    {
        $tripService = new TripService();
        $tripStatuses = $tripService->canNotHaveOrderInDelayOrderStatuses();
        $this->assertTrue(count($tripStatuses) == 3);
        foreach ($tripStatuses as $key => $value) {
            $this->assertTrue(in_array($key, [
                TripService::STATUS_ASSIGNED,
                TripService::STATUS_AT_VENDOR,
                TripService::STATUS_PICKED,
            ]));
            $this->assertTrue(in_array($value, [
                TripService::STATUS_ASSIGNED,
                TripService::STATUS_AT_VENDOR,
                TripService::STATUS_PICKED,
            ]));
        }
    }
}
