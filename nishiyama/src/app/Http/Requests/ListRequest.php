<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'search' => 'nullable|string',
            'order_by' => 'nullable|string',
            'sort_order' => 'nullable|string|in:asc,desc',
            'paginate' => 'nullable|boolean',
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1'
        ];
    }
}
