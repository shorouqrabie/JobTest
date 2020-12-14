<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePersonRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => ['required', 'regex:/[A-Z].*\d|\d.*[A-Z]/'],
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'username' => ['required', 'min:8', 'regex:/([A-Za-z]+[0-9]|[0-9]+[A-Za-z])[A-Za-z0-9]*/'],
            'age' => 'required|integer|between:10,85',
            'biography' => 'required|min:10',
            'imgfile' => 'required|image'
        ];
    }


    public function messages()
    {
        return [
            'username.regex' => 'Please enter a combination of letters and numbers.',
            'password.regex' => 'Password must contains a combination of letters and numbers with at least one Capital letter.',
            'name.regex' => 'Please enter letters only.',
            'imgfile.required' => 'Please upload photo.',
            'imgfile.image' => 'File must be an image file.',
        ];
    }


    public function failedValidation(Validator $validator) {
         throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
