<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotLoginValidation extends FormRequest
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
            'email'=>'required|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('Please enter email'),
            'email.email' => trans('Please enter valid email')
        ];
    }

    /*protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse(['data' => [],
                'meta' => [
                    'message' => 'The given data is invalid', 
                    'errors' => $validator->errors()
                ]], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
                'data' => [], 
                'meta' => [
                    'message' => 'The given data is invalid', 
                    'errors' => $exception->errors()
                ]
                ], $exception->status);
    }*/
}
