<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartListRequest extends FormRequest
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
            'id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'status' => 'nullable|integer',            
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1'
        ];
    }
}
