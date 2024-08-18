<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório.',
            'name.string' => 'O nome do serviço deve ser uma string.',
            'name.max' => 'O nome do serviço não pode ter mais que 255 caracteres.',
            'price.required' => 'O preço do serviço é obrigatório.',
            'price.numeric' => 'O preço do serviço deve ser um valor numérico.',
            'price.min' => 'O preço do serviço deve ser um valor positivo.',
        ];
    }
}
