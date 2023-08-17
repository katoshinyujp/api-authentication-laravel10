<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FormRequest extends HttpFormRequest
{
    public function failedValidation(Validator $validator)
    {
        Log::alert($validator->errors());
        throw new HttpResponseException(response()->json([
            'code' => intval(Response::HTTP_UNPROCESSABLE_ENTITY.'000'),
            'status' => config('api.response_status_invalid'),
            'data' => $validator->errors(),
            'message' => null,
        ]));
    }
}
