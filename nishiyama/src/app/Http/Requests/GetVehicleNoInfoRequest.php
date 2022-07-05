<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetVehicleNoInfoRequest extends FormRequest
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
            'car_model_designation_no' => 'required|string|max:5|exists:car_models,car_model_designation_no',
            'classification_no' => 'required|string|max:4|exists:grades,classification_no'
        ];
    }
}
