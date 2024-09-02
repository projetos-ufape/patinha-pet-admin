<?php

namespace App\Http\Api\Requests;

use App\Enums\AddressState;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class CustomerSignUpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cpf' => ['required', 'string'],
            'phone_number' => ['required', 'numeric', 'digits:11'],
            'address' => ['sometimes', 'array'],
            'address.cep' => ['sometimes', 'size:8'],
            'address.street' => ['required_with:address', 'min:3', 'max:50'],
            'address.number' => ['nullable', 'string', 'min:1', 'max:10'],
            'address.district' => ['required_with:address', 'min:3', 'max:50'],
            'address.city' => ['required_with:address', 'min:3', 'max:50'],
            'address.complement' => ['string', 'max:50'],
            'address.state' => ['required_with:address', Rule::enum(AddressState::class)],
        ];
    }
}
