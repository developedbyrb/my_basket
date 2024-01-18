<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('Shopkeeper') || Auth::user()->hasRole('Supplier');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'addresses.*.house_no' => 'required',
            'addresses.*.area' => 'required',
            'addresses.*.city' => 'required',
            'addresses.*.pincode' => 'required',
            'addresses.*.state' => 'required',
            'addresses.*.country' => ['required'],
            'addresses.*.alias' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a shop name.',
            'addresses.*.house_no.required' => 'Please enter a house number address #:position.',
            'addresses.*.area.required' => 'Please enter an area address #:position.',
            'addresses.*.city.required' => 'Please enter a city address #:position.',
            'addresses.*.pincode.required' => 'Please enter a pincode address #:position.',
            'addresses.*.state.required' => 'Please enter a state address #:position.',
            'addresses.*.country.required' => 'Please enter a country address #:position.',
            'addresses.*.alias.required' => 'Please enter an alias address  #:position.',
        ];
    }
}
