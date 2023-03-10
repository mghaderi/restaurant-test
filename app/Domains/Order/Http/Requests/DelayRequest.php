<?php

namespace App\Domains\Order\Http\Requests;

use App\Http\Requests\BasicRequest;

class DelayRequest extends BasicRequest
{
    public function rules()
    {
        return [
            'order_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
