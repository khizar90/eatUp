<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

class RatingRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'food_id' => 'required|exists:sub_categories,id',
            'rating' => 'required|numeric'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $obj = new stdClass();
        throw new HttpResponseException(response()->json([

            'status'   => false,
            'action' => "Rating not added",
            'data' => $obj,
            'error' => $validator->errors()->all()
        ]));
    }
}
