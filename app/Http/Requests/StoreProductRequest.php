<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('Supplier') || Auth::user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => 'required|string|max:255',
            // 'categories' => 'required|exclude',
            // 'image' => 'required|mimes:png,jpg,jpeg|max:2048|exclude',
            'description' => 'nullable',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }

    public function validated($key = null, $default = null)
    {
        return array_merge(parent::validated(), [
            'slug' => Str::slug($this->name),
            'created_by' => Auth::user()->id,
        ]);
    }
}
