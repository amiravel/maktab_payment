<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
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
            'mobile' => 'nullable|min:11',
            'description' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'required|integer|exists:tags,id',
            'amount' => 'required|integer|min:10000',
            'callback' => 'required|url',
            'information' => 'nullable|array'
        ];
    }
}
