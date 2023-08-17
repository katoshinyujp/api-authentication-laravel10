<?php

namespace App\Http\Requests;

class ResetPassword extends FormRequest
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
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:'.config('api.min_password').'|confirmed',
		];
    }

    public function messages()
    {
        return [
            'token.required' => trans('user.token.required'),
            'email.required' => trans('user.email.required'),
            'email.email' => trans('user.email.email'),
            'password.required' => trans('user.password.required'),
            'password.confirmed' => trans('user.password.confirmed'),
            'password.min' => trans('user.password.min', ['min' => config('api.min_password')]),
        ];
    }
}
