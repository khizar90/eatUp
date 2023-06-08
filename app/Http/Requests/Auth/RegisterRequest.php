<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

class RegisterRequest extends FormRequest
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
            'platform' => 'required',
            'phone' => 'required_if:platform,normal',
            'password' => 'required_if:platform,normal|min:6',
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'device_name' => 'required',
            'device_id' => 'required',
            'timezone' => 'required',
            'token' => 'required',


            // 'email' => 'required_if:platform,google,facebook|email',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $obj = new stdClass();


        throw new HttpResponseException(response()->json([

            'status'   => false,
            'action' => "Register failed",
            'data' => $obj,
            'error' => $validator->errors()->all()
        ]));
    }
}
