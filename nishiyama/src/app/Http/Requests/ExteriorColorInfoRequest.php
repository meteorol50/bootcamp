<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExteriorColorInfoRequest extends FormRequest
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
            'maker_id' => 'nullable|integer|exists:makers,id',
            'car_id' => 'nullable|integer|exists:cars,id',
            'car_model_id' => 'nullable|integer|exists:car_models,id',
            'car_model_designation_no' => 'nullable|string|exists:car_models,car_model_designation_no',
            'classification_no' => 'nullable|string|exists:grades,classification_no',
            'status' => 'nullable|integer',
            'limit' => 'nullable|integer|min:1',
            'offset' => 'nullable|integer|min:0'
        ];
    }
}
