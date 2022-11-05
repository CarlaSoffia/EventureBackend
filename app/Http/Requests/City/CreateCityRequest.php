<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class CreateCityRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:App\Models\City,name'],
            'country_id' => ['required','integer','exists:countries,id']
        ];
    }
    public function messages(){
        return [
            'name.required' => "City's name is required",
            'name.string' => "City's name must be a string",
            'unique:App\Models\City,name' => 'City already exists',
            'country_id.required' => "Country is required",
            'country_id.integer' => "Country must be a string",
            'country_id.exists' => "Country doesn't exists",
        ];
    }
}
