<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
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
            'avg_time_minutes' => ['required','numeric', 'min:0'],
            'category_id'=> ['required','integer','exists:categories,id'],
            //location
            'city_id' => ['required','integer','exists:cities,id'],
            'gps_longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'gps_latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/']
        ];
    }
    public function messages()
    {
        return [
            'designation.required' => "Activity's designation is required",
            'designation.string' => "Activity's designation must be a string",
            'avg_price.required' => "Activity's average price is required",
            'avg_price.numeric' => "Activity's average price must be numeric",
            'avg_price.min' => "Activity's average price must be bigger than 0",
            'avg_ratings.required' => "Activity's average ratings is required",
            'avg_ratings.numeric' => "Activity's average ratings must be numeric",
            'avg_ratings.min' => "Activity's average ratings must be bigger than 0",
            'avg_time_minutes.required' => "Activity's average time (seconds) is required",
            'avg_time_minutes.numeric' => "Activity's average time (seconds) must be numeric",
            'avg_time_minutes.min' => "Activity's average time (seconds) must be bigger than 0",
            "category_id.required" => "Activity's category is required",
            "category_id.integer" => "Activity's category must be an integer",
            'category_id.exists' => "Activity's category doesn't exist",
            "city_id.required" => "Activity's city is required",
            "city_id.integer" => "Activity's city must be an integer",
            'city_id.exists' => "Activity's City doesn't exist",
            'gps_longitude.required' => "Activity's GPS Longitude coordinate doesn't exist",
            'gps_longitude.regex' => "Activity's GPS Longitude is invalid",
            'gps_latitude.required' => "Activity's GPS Latitude coordinate doesn't exist",
            'gps_latitude.regex' => "Activity's GPS Latitude is invalid",
        ];
    }
}
