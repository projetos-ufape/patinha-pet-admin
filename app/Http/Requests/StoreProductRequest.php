<?php

namespace App\Http\Requests;

use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'description' => ['string', 'max:255'],
            'brand' => ['string', 'max:255'],
            'category' => ['required', Rule::enum(ProductCategory::class)],
            'price' => ['required', 'decimal:2', 'min:0', 'max:100000'],
        ];
    }
}
