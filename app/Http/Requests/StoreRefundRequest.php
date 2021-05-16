<?php

namespace App\Http\Requests;

use App\Rules\CardNumber;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'string',
            'mobile' => 'required|digits:11',
            'email' => 'required|email',
            'refID' => 'required|numeric',
            'card_number' => ['required', 'digits:16'],
            'iban' => 'digits:24',
            'amount' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'card_number' => "شماره کارت",
            'iban' => "شماره شبا",
        ];
    }
}
