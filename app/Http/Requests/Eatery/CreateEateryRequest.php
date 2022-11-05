<?php

namespace App\Http\Requests\Eatery;

use Illuminate\Foundation\Http\FormRequest;

class CreateEateryRequest extends FormRequest
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
            'designation' => ['required', 'string'],
            'avg_price' => ['required','numeric', 'min:0'],
            'avg_ratings' => ['required','numeric', 'min:0'],
            //location
            'city_id' => ['required','integer','exists:cities,id'],
            'gps_longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'gps_latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/']
        ];
    }
    public function messages()
    {
        return [
            'designation.required' => "Eatery's designation is required",
            'designation.string' => "Eatery's designation must be a string",
            'avg_price.required' => "Eatery's average price is required",
            'avg_price.numeric' => "Eatery's average price must be numeric",
            'avg_price.min' => "Eatery's average price must be bigger than 0",
            'avg_ratings.required' => "Eatery's average ratings is required",
            'avg_ratings.numeric' => "Eatery's average ratings must be numeric",
            'avg_ratings.min' => "Eatery's average ratings must be bigger than 0",
            "city_id.required" => "Eatery's city is required",
            "city_id.integer" => "Eatery's city must be an integer",
            'city_id.exists' => "Eatery's City doesn't exist",
            'gps_longitude.required' => "Eatery's GPS Longitude coordinate doesn't exist",
            'gps_longitude.regex' => "Eatery's GPS Longitude is invalid",
            'gps_latitude.required' => "Eatery's GPS Latitude coordinate doesn't exist",
            'gps_latitude.regex' => "Eatery's GPS Latitude is invalid",
        ];
    }
}
