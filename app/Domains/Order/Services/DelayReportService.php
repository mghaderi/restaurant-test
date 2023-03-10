<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\DelayReport;

class DelayReportService
{

    public const TYPE_WITH_DELAY = 'with_delay';
    public const TYPE_NO_DELAY = 'no_delay';

    private ?DelayReport $model;

    public function __construct(?DelayReport $delayReport = null)
    {
        $this->model  = $delayReport;
    }

    public function types(): array
    {
        return [
            self::TYPE_WITH_DELAY => self::TYPE_WITH_DELAY,
            self::TYPE_NO_DELAY => self::TYPE_NO_DELAY,
        ];
    }
}
