<?php

namespace App\Http\Requests\Travel;

use Illuminate\Foundation\Http\FormRequest;

class CreateTravelRequest extends FormRequest
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
            "user_id" => ['required','integer','exists:users,id'],
            "accomodation_id" => ['required','integer','exists:accomodations,id'],
            "city_id" => ['required','integer','exists:cities,id'],
            "days" => ['required','integer','min:1'],
            "avg_distance" => ['required','numeric','min:0'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => "Travel's user is required",
            'user_id.integer' => "Travel's user must be numeric",
            'user_id.exists' => "Travel's user doesn't exist",

            'accomodation_id.required' => "Travel's accomodation is required",
            'accomodation_id.integer' => "Travel's accomodation must be numeric",
            'accomodation_id.exists' => "Travel's accomodation doesn't exist",

            'city_id.required' => "Travel's city is required",
            'city_id.integer' => "Travel's city must be numeric",
            'city_id.exists' => "Travel's city doesn't exist",

            'days.required' => "Travel's duration days is required",
            'days.integer' => "Travel's duration days must an integer",
            'days.min' => "Travel must last longer than a day",

            'avg_distance.required' => "Travel's average distance is required",
            'avg_distance.numeric' => "Travel's average distance must be numeric",
            'avg_distance.min' => "Travel average distance must be positive",
        ];
    }
}
