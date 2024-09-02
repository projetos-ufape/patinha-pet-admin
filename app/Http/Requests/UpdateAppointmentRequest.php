<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['exists:customers,id'],
            'pet_id' => ['exists:pets,id'],
            'service_id' => ['exists:services,id'],
            'status' => [Rule::enum(AppointmentStatus::class)],
            'start_time' => ['date'],
            'end_time' => ['nullable', 'date', 'after:start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'O campo de cliente deve ser preenchido por um id válido.',
            'pet_id.exists' => 'O campo de pet deve ser preenchido por um id válido.',
            'service_id.exists' => 'O campo de serviço deve ser preenchido por um id válido.',
            'status' => 'O status do atendimento deve ser "pendente", "concluído" ou "cancelado".',
            'start_time.date' => 'O horário para o atendimento deve ser uma data-hora válida.',
            'end_time.date' => 'O horário de conclusão do atendimento deve ser uma data-hora válida.',
            'end_time.after' => 'O horário de conclusão do atendimento não pode ser anterior ao de início.',
        ];
    }
}
