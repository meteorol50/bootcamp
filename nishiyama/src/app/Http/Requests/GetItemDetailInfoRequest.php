<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetItemDetailInfoRequest extends FormRequest
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
            // 'item_id' => 'required|integer|exists:items,id',
            'matching_parts_no' => 'required|integer|in:0,1,2,3,9'
        ];
    }
}
