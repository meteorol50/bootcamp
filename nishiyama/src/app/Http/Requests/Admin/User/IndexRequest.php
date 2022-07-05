<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'name'              => 'nullable|string',
            'email'             => 'nullable|string',
            'tel'               => 'nullable|string',
            'type_comp'         => 'boolean',
            'type_sole_comp'    => 'boolean',
            'type_indvl'        => 'boolean',
            'sts_unapp'         => 'boolean',
            'sts_app'           => 'boolean',
            'sts_mail'          => 'boolean',
        ];
    }
}
