<?php

namespace App\Domains\Transport\Services;

use App\Domains\Order\Models\Order;
use App\Domains\Transport\Models\Transporter;
use App\Domains\Transport\Models\Trip;

class TransporterService
{

    private ?Transporter $model;

    public function __construct(?Transporter $transporter = null)
    {
        $this->model  = $transporter;
    }

    public function fetchData(): array
    {
        if (empty($this->model)) {
            return [];
        }
        $name = empty($this->model->name) ?  '' : $this->model->name;
        $family = empty($this->model->family) ?  '' : $this->model->family;
        $number = empty($this->model->number) ?  '' : $this->model->number;
        return [
            'name' => $name,
            'family' => $family,
            'number' => $number
        ];
    }
}
