<?php

namespace Tests\Unit\Order\Services;

use PHPUnit\Framework\TestCase;
use App\Domains\Order\Services\DelayReportService;

class DelayReportServiceTest extends TestCase
{
    /** @test */
    public function test_delay_report_types(): void
    {
        $types = (new DelayReportService())->types();
        $this->assertTrue(count($types) == 2);
        foreach ($types as $key => $value) {
            $this->assertTrue(in_array($key, [
                DelayReportService::TYPE_WITH_DELAY,
                DelayReportService::TYPE_NO_DELAY,
            ]));
            $this->assertTrue(in_array($value, [
                DelayReportService::TYPE_WITH_DELAY,
                DelayReportService::TYPE_NO_DELAY,
            ]));
            $this->assertTrue($key == $value);
        }
    }
}
