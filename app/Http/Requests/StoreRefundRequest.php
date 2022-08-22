<?php

namespace App\Http\Requests;

use App\Rules\CC;
use App\Rules\IBAN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRefundRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required',
            'payment_id' => 'required_without:refID|nullable|min:1|numeric',
            'refID' => 'required_without:payment_id|nullable|min:1|numeric',
            'card_number' => ['required', new CC()],
            'iban' => ['required', new IBAN()],
            'amount' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'payment_id' => 'شماره تراکنش',
            'refID' => 'شماره ارجاع',
            'card_number' => 'شماره کارت',
            'iban' => 'شماره شبا'
        ];
    }
}
