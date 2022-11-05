<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:App\Models\Country,name'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Country's name is required",
            'name.string' => "Country's name must be a string",
            'unique:App\Models\Country,name' => 'The Country has already been taken',
        ];
    }
}
