<?php

namespace App\Http\Requests;

use App\Enums\AddressState;
use App\Enums\EmployeeType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreEmployeeRequest extends FormRequest
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
            'password' => ['required', 'confirmed', Password::defaults()],
            'cpf' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
            'type' => ['required', Rule::enum(EmployeeType::class)],
            'admission_date' => ['required', 'date', 'date_format:Y-m-d'],
            'address' => ['sometimes', 'array'],
            'address.cep' => ['sometimes', 'size:8'],
            'address.street' => ['required_with:address', 'min:3', 'max:50'],
            'address.number' => ['required_with:address', 'string', 'min:1', 'max:10'],
            'address.district' => ['required_with:address', 'min:3', 'max:50'],
            'address.city' => ['required_with:address', 'min:3', 'max:50'],
            'address.complement' => ['string', 'max:50'],
            'address.state' => ['required_with:address', Rule::enum(AddressState::class)],
        ];
    }
}
