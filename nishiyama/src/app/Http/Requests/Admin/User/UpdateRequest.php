<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'image' => 'nullable|string',   // プロフィール画像パス
            'name'  => 'string|max:255',    // 名前
            'email' => 'email',             // メールアドレス
            // 【TODO：正規表現でチェック】
            'tel'   => 'string|max:11',   // 電話番号
            'other' => 'string|max:255',    // その他
        ];
    }
}
