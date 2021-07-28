<?php

namespace App\Http\Requests\OrganizationConfigs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'company_name'=>['required','string','max:255'],
            'logo'=>['nullable','image','mimes:jpg,png,svg','max:1024'],
            'phone_number'=>['required','string','max:30'],
            'tax_id'=>['required','string','max:30'],
            'thankyou_message'=>['required','string','max:255']
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => "Organization / Company must be filled",
            'phone_number.max'=> "Phone Number is too long",
            'tax_id.max' => "Tax ID is too long",
            'tax_id.required'=> "Tax ID must be filled",
            "thankyou_message.required" => "Please put your thankyou message, saying thank you make a good impression with the client" 
        ];
    }
}
