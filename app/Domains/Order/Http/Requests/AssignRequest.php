<?php

namespace App\Domains\Order\Http\Requests;

use App\Http\Requests\BasicRequest;

class AssignRequest extends BasicRequest
{
    public function rules()
    {
        return [
            'employee_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
