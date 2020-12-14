<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'min:8', 'regex:/([A-Za-z]+[0-9]|[0-9]+[A-Za-z])[A-Za-z0-9]*/'],
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'Please enter a combination of letters and numbers.',
        ];
    }


    public function failedValidation(Validator $validator) {
         throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
