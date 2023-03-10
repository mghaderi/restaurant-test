<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\User;
use App\Http\Responses\BasicResponse;

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

    public function fetchEmployee(int $employeeId): User
    {
        $employee = User::where('id', $employeeId)
            ->where('type', UserService::TYPE_EMPLOYEE)
            ->first();
        if (empty($employee)) {
            (new BasicResponse)->notFoundError('can not find employee.');
        }
        return $employee;
    }
}
