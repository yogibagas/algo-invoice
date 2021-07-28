<?php

namespace App\Http\Requests\Invoice;

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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_id'=> ['nullable'],
            'client_id' => ['required'],
            'no_inv' => ['required','string','max:75'],
            'status'=>['required','string','max:25'],
            'due_date'=>['required','date'],
            'total'=>['nullable','numeric'],
            'item_note'=>['nullable'],
            'item_name.*'=>['required','string'],
            'item_qty_type.*'=>['required','string'],
            'item_qty.*'=>['required','numeric','min:1'],
            'item_price.*'=>['required','numeric','min:1'],
            'item_adjustment.*'=>['nullable']
        ];
    }

    public function messages(){
        return [
            'client_id.required'=>'You have to select the client first',
            'no_inv,required'=> 'Invoice no need to be filled',
            'status.required'=>'Select status invoice to be stored',
            'due_date.required'=>'Please choose the due date payment',
            'item_name.*.required'=>'Item name not allowed to be empty',
            'item_qty.*.required'=>'Quantity not allowed to be empty',
            'item_qty.*.numeric'=>'Quantity only allowed with numeric value',
            'item_qty.*.min'=>'Minimum items quantity allowed is 1',
            'item_price.*.required'=>'Price for item is required',
            'item_price.*.numeric'=>'Price item only allowed numeric value',
            'item_price.*.min'=>'Minimum items price allowed is 1',
        ];
    }
}
