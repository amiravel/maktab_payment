<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'mobile' => 'required|phone:AUTO,IR',
            'description' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'required|integer|exists:tags,id',
            'amount' => 'required|integer',
            'callback' => 'required|url',
            'information' => 'nullable|array'
        ];
    }
}
