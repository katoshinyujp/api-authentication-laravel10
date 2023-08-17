<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\Password;


class LoginUser extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:'.config('api.min_password')
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('user.name.required'),
            'email.email' => trans('user.name.email'),
            'password.required' => trans('user.password.required'),
            'password.min' => trans('user.password.min', ['min' => config('api.min_password')]),
        ];
    }
}
