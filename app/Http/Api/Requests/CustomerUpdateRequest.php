<?php

namespace App\Http\Api\Requests;

use App\Enums\AddressState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'phone_number' => ['sometimes', 'numeric', 'digits:11'],
            'address' => ['sometimes', 'array'],
            'address.cep' => ['sometimes', 'size:8'],
            'address.street' => ['sometimes', 'min:3', 'max:50'],
            'address.number' => ['sometimes', 'nullable', 'string', 'min:1', 'max:10'],
            'address.district' => ['sometimes', 'min:3', 'max:50'],
            'address.city' => ['sometimes', 'min:3', 'max:50'],
            'address.complement' => ['sometimes', 'string', 'max:50'],
            'address.state' => ['sometimes', Rule::enum(AddressState::class)],
        ];
    }
}
