<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\User;

class UserService
{

    public const TYPE_EMPLOYEE = 'employee';
    public const TYPE_CUSTOMER = 'customer';

    private ?User $model;

    public function __construct(?User $user = null)
    {
        $this->model  = $user;
    }

    public function types(): array
    {
        return [
            self::TYPE_CUSTOMER => self::TYPE_CUSTOMER,
            self::TYPE_EMPLOYEE => self::TYPE_EMPLOYEE,
        ];
    }
}
