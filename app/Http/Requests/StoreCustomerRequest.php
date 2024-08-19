<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf), 
            'phone_number' => preg_replace('/\D/', '', $this->phone_number), 
        ]);
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128'],
            'cpf' => ['required', "size:11", 'string', 'unique:users,cpf'],
            'phone_number' => ['required', 'string', 'digits:11'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'phone_number.required' => 'O campo número de telefone é obrigatório.',
            'phone_number.max' => 'O campo número de telefone não pode ter mais de :max caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Insira um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ];
    }
}
