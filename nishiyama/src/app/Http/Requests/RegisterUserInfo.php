<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserInfo extends FormRequest
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
            'email' => 'required|string|email|exists:users,email',
            'type' => 'required|integer|in:1,2,3',
            'image' => 'nullable|image|max:5120',
            'password' => 'required|string|min:8',
            'company_name' => 'nullable|string',
            'user_name' => 'required|string',
            'position' => 'nullable|string',
            'postal_code' => 'required|string',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'city' => 'required|string',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'tel' => 'required|numeric',
            'fax' => 'nullable|numeric',
            'other' => 'nullable|string'
        ];
    }
}
