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
        return Auth::user()->hasRole('Shopper');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_type' => 'required',
            'addresses.*.house_no' => 'required',
            'addresses.*.area' => 'required',
            'addresses.*.city' => 'required',
            'addresses.*.pincode' => 'required',
            'addresses.*.state' => 'required',
            'addresses.*.country' => 'required'
        ];
    }
}
