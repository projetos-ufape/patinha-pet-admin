<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'pet_id' => ['required', 'exists:pets,id'],
            'service_id' => ['required', 'exists:services,id'],
            'status' => [Rule::enum(AppointmentStatus::class)],
            'start_time' => ['required', 'date_format:Y-m-d\TH:i'],
            'end_time' => ['nullable', 'date_format:Y-m-d\TH:i', 'required_if:status,' . AppointmentStatus::Completed->value],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'O campo de cliente é obrigatório.',
            'customer_id.exists' => 'O campo de cliente deve ser preenchido por um id válido.',
            'pet_id.required' => 'O campo de pet é obrigatório.',
            'pet_id.exists' => 'O campo de pet deve ser preenchido por um id válido.',
            'service_id.required' => 'O campo de serviço é obrigatório.',
            'service_id.exists' => 'O campo de serviço deve ser preenchido por um id válido.',
            'status' => 'O status do atendimento deve ser "pendente", "concluído" ou "cancelado".',
            'start_time.required' => 'O campo de horário do atendimento é obrigatório.',
            'start_time.date_format' => 'O horário para o atendimento deve ser uma data-hora válida.',
            'end_time.date_format' => 'O horário de conclusão do atendimento deve ser uma data-hora válida.',
            'end_time.required_if' => 'O campo horário de conclusão do atendimento é obrigatório quando o status é "concluído".'
        ];
    }
}
