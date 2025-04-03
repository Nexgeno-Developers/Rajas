<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValidation extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name'=>'required|string|unique:categories',
                ];
                break;
            }
            case 'PATCH':
                case 'PUT':
                    {
                        return [
                            'name'=>'required'
                        ];
                        break;
                    }
            }
    }

    public function messages()
    {
        return [
            'name.required' => trans('Please enter category name'),
            'name.string' => trans('Category name must be characters'),
            'name.unique' => trans('Category name already exists in the system')
        ];
    }
}

