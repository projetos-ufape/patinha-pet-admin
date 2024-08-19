<?php

namespace App\Http\Requests;

use App\Enums\ProductCategory;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique(Product::class)->ignore($this->route('product'))],
            'description' => ['string', 'max:255'],
            'brand' => ['string', 'max:255'],
            'category' => ['required', Rule::enum(ProductCategory::class)],
            'price' => ['required', 'numeric', 'min:0', 'regex:/^\d{1,5}(\.\d{1,2})?$/'],
            'quantity' => ['required', 'integer', 'min:0'],
        ];
    }
}
