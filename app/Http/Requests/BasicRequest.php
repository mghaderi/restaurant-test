<?php

namespace App\Http\Requests;

use App\Http\Requests\BasicRequest as RequestsBasicRequest;
use App\Http\Responses\BasicResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BasicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        (new BasicResponse())->validationError($validator->errors());
    }
}
