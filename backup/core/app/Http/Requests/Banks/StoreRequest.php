<?php

namespace App\Http\Requests\Banks;

use Illuminate\Foundation\Http\FormRequest;

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
            //
            'bank_name' => ['required','string','max:255'],
            'shortname' => ['required','string','max:30'],
            'bank_number'=> ['required','numeric','digits_between:6,30'],
            'bank_swift'=> ['required','string','max:12'],
            'bank_code'=> ['required', 'numeric','digits_between:2,6'],
            'bank_holder_name'=> ['required','string','max:255'],
            'status'=> ['required','string','max:15']
        ];
    }
    public function messages(){
        return [
            'bank_name.required' => 'Bank Name must be filled',
            'shortname.required' => 'Bank Shortname must be filled',
            'shortname.max'=> 'The maximum of shortname is 30 character',
            'bank_number.numeric'=> 'Bank number only accept numeric value',
            'bank_swift.max'=> 'Bank Swift Code only accept maximum 13 character',
            'bank_code.numeric'=> 'Bank Code only accept numeric value',
            'bank_code.max'=> 'Bank Code maximum only accept maximum 8 number',
            'bank_holder_name'=> 'Bank Holder must be filled',
            'status.required'=> 'Status must to be filled'
        ];
    }
}
