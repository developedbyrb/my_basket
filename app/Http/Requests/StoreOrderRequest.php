<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('Shopper') || Auth::user()->hasRole('Shopkeeper');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validationArray = [
            'email' => ['required', 'string', 'email'],
            'payment_type' => ['required'],
        ];

        if (Auth::user()->hasRole('Shopkeeper')) {
            $validationArray = array_merge($validationArray, [
                'address' => ['required'],
            ]);
        }

        if (Auth::user()->hasRole('Shopper')) {
            $validationArray = array_merge($validationArray, [
                'addresses.*.house_no' => 'required',
                'addresses.*.area' => 'required',
                'addresses.*.city' => 'required',
                'addresses.*.pincode' => 'required',
                'addresses.*.state' => 'required',
                'addresses.*.country' => ['required'],
            ]);
        }

        return $validationArray;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'addresses.*.house_no.required' => 'Please enter a house number address.',
            'addresses.*.area.required' => 'Please enter an area address.',
            'addresses.*.city.required' => 'Please enter a city address.',
            'addresses.*.pincode.required' => 'Please enter a pincode address.',
            'addresses.*.state.required' => 'Please enter a state address.',
            'addresses.*.country.required' => 'Please enter a country address.',
        ];
    }
}
