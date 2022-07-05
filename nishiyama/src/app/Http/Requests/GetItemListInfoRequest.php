<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetItemListInfoRequest extends FormRequest
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
            'car_model_designation_no' => 'nullable|string|exists:car_models,car_model_designation_no|required_if:parts_no_match_flg,1,true',
            'classification_no' => 'nullable|string|exists:grades,classification_no|required_if:parts_no_match_flg,1,true',
            'vehicle_no' => 'nullable|string|exists:cars_info,vehicle_no|required_if:parts_no_match_flg,1,true',
            'parts_no_match_flg' => 'nullable|boolean',
            'lower_price_limit' => 'nullable|integer',
            'price_limit' => 'nullable|integer',
            'quality_rank' => 'nullable|string|valid_quality_ranks',
            'rebuilt_new_outside' => 'nullable|integer|digits:1',
            'mileage_lower_limit' => 'nullable|integer',
            'mileage_upper_limit' => 'nullable|integer',
            'color_id' => 'nullable|integer|exists:colors,id',
            'parts_id' => 'required|array',
            'parts_id.*' => 'required|integer|exists:parts,id',
            'on_sale_flg' => 'nullable|boolean',
            'sort' => 'required|integer|min:1|max:7',
            'limit' => 'nullable|integer|min:1',
            'offset' => 'nullable|integer|min:0'
        ];
    }
}
