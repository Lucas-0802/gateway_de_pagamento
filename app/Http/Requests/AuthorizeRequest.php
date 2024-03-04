<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AuthorizeRequest extends FormRequest
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
            'gatewayName' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'token' => 'required|string',
            'card' => 'required|array',
            'card.number' => 'required|string|size:16', 
            'card.expiryMonth' => 'required|numeric|between:1,12', 
            'card.expiryYear' => 'required|numeric|digits:2', 
            'card.cvv' => 'required|string|size:3', 
            'card.firstName' => 'required|string',
            'card.lastName' => 'required|string',
            'card.billingAddress1' => 'nullable|string',
            'card.billingAddress2' => 'nullable|string',
            'card.billingCity' => 'nullable|string',
            'card.billingPostcode' => 'nullable|string',
            'card.billingState' => 'nullable|string',
            'card.billingCountry' => 'nullable|string|max:4', 
            'card.billingPhone' => 'nullable|string',
            'card.shippingAddress1' => 'nullable|string',
            'card.shippingAddress2' => 'nullable|string',
            'card.shippingCity' => 'nullable|string',
            'card.shippingPostcode' => 'nullable|string',
            'card.shippingState' => 'nullable|string',
            'card.shippingCountry' => 'nullable|string|max:3',
            'card.shippingPhone' => 'nullable|string',
            'card.company' => 'nullable|string',
            'card.email' => 'nullable|email'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ],422));
    }  
}

