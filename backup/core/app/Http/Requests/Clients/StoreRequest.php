<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'name'=> ['required','string','max:255'],
            'pic_name'=> ['required','string','max:255'],
            'code' => ['required','unique:clients','string','max:12'],
            'address' => ['required','max:255','string'],
            'phone' => ['required','string','max:25'],
            'email' => ['required','email']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name field need to be filled',
            'pic_name.required' => 'PIC Name field need to be filled',
            'code.required' => 'Client Code need to be filled, this will be used for invoice number',
            'code.max'=>'Client Code can\'t more than 12 character',
            'address.required'=> 'Address need to be filled, this will be used for billing address in invoice',
            'phone.required'=> 'Phone number need to be filled this will be used for contact info in invoice',
            'phone.max' => 'Phone number is too long maximum is 25'
        ];
    }
}
