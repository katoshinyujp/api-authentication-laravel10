<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:'.config('api.min_password')
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('user.name.required'),
            'email.required' => trans('user.email.required'),
            'email.email' => trans('user.email.email'),
            'email.unique' => trans('user.email.unique'),
            'password.required' => trans('user.password.required'),
            'password.min' => trans('user.password.min', ['min' => config('api.min_password')]),
        ];
    }
}
