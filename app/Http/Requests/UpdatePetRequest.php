<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\Specie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePetRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::enum(Gender::class)],
            'specie' => ['nullable', Rule::enum(Specie::class)],
            'race' => ['nullable', 'string', 'max:255'],
            'castrated' => ['nullable', 'boolean'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'birth' => ['nullable', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O nome do pet deve ser uma string.',
            'name.max' => 'O nome do pet não pode ter mais de 255 caracteres.',
            'gender.enum' => 'O gênero do pet deve ser "female" ou "male".',
            'specie.enum' => 'A espécie do pet deve ser "cat" ou "dog".',
            'race.string' => 'A raça do pet deve ser uma string.',
            'race.max' => 'A raça do pet não pode ter mais de 255 caracteres.',
            'height.numeric' => 'A altura do pet deve ser um número.',
            'weight.numeric' => 'O peso do pet deve ser um número.',
            'birth.date' => 'A data de nascimento do pet deve ser uma data válida.',
            'birth.before_or_equal' => 'A data de nascimento do pet não pode ser uma data futura.',
        ];
    }
}
