<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:App\Models\Category,name'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Category's name is required",
            'name.string' => "Category's name must be a string",
            'unique:App\Models\Category,name' => 'The category has already been taken',
        ];
    }
}
