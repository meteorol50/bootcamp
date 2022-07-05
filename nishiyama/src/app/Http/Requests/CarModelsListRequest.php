<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModelsListRequest extends FormRequest
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
            'car_id' => 'nullable|integer|exists:car_models,car_id',
            'model_from_year' => 'nullable|date_format:Y',
            'model_from_month' => 'nullable|date_format:m',
            'model_to_year' => 'nullable|date_format:Y',
            'model_to_month' => 'nullable|date_format:m',
            'name' => 'nullable|string',
            'car_model_designation_no' => 'nullable|string|max:5',
            'status' => 'nullable|integer',
            'paginate' => 'nullable|boolean',
            'limit' => 'nullable|integer|min:1',
            'offset' => 'nullable|integer|min:0'
        ];
    }
}
