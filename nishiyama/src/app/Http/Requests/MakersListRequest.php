<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakersListRequest extends FormRequest
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
            'id' => 'nullable|integer|exists:makers,id',
            'status' => 'nullable|integer',
            'limit' => 'nullable|integer|min:1',
            'offset' => 'nullable|integer|min:0',
            'search' => 'nullable|string'
        ];
    }
}