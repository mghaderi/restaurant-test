<?php

namespace App\Http\Responses;

use Illuminate\Http\Exceptions\HttpResponseException;

class BasicResponse
{
    public function ok($data, $status = 200)
    {
        return response()->json([
            'message'   => 'Success',
            'data'      => $data
        ], $status);
    }

    public function validationError($errors)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation Error',
            'data'      => $errors
        ], 422));
    }

    public function notFoundError($errors)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Not Found Error',
            'data'      => $errors
        ], 404));
    }

    public function error($errors)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Server Error',
            'data'      => $errors
        ], 500));
    }
}
