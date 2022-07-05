<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterShippingRequest extends FormRequest
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
            "name"		=>	"required|string|max:50",						
            "postal_code"=>	"required|string|between:5,7",								
            "prefecture_id"	=>"required|integer",								
            "city"	=>	"required|string|max:60",							
            "address"=>	"required|string|max:190",								
            "building" => "nullable|string|max:100",						
            "tel"=> "required|string|between:6,14",							
        ];
    }
}
