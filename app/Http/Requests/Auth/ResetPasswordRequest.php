<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

class ResetPasswordRequest extends FormRequest
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
            'country_code' => 'required',
            'phone' => 'required'
            
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
