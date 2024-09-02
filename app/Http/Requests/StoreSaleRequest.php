<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'sale_items' => 'required|array|min:1',
            'sale_items.*.price' => 'required|numeric|min:0',
            'sale_items.*.type' => 'required|in:product,appointment',
            'sale_items.*.product_item.product_id' => 'required_if:sale_items.*.type,product|exists:products,id',
            'sale_items.*.product_item.quantity' => 'required_if:sale_items.*.type,product|integer|min:1',
            'sale_items.*.appointment_item.appointment_id' => 'required_if:sale_items.*.type,appointment|exists:appointments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'O cliente é obrigatório.',
            'customer_id.exists' => 'O cliente deve existir.',
            'sale_items.required' => 'Os itens de venda são obrigatórios.',
            'sale_items.array' => 'Os itens de venda devem estar em um array.',
            'sale_items.min' => 'Devem haver :min ou mais itens de venda.',
            'sale_items.*.price.required' => 'O preço de cada item de venda é obrigatório.',
            'sale_items.*.price.numeric' => 'O preço de cada item de venda deve ser um número.',
            'sale_items.*.price.min' => 'O preço de cada item de venda deve ser :min ou mais.',
            'sale_items.*.type.required' => 'O tipo de cada item de venda é obrigatório.',
            'sale_items.*.type.in' => 'O tipo de cada item de venda deve ser um de in:.',
            'sale_items.*.product_item.product_id.required_if' => 'O produto de cada item de venda de produto é obrigatório.',
            'sale_items.*.product_item.product_id.exists' => 'O produto de cada item de venda de produto deve existir.',
            'sale_items.*.product_item.quantity.required_if' => 'A quantidade de cada item de venda de produto é obrigatório.',
            'sale_items.*.product_item.quantity.integer' => 'A quantidade de cada item de venda de produto deve ser um número.',
            'sale_items.*.product_item.quantity.min' => 'A quantidade de cada item de venda de produto deve ser :min ou mais.',
            'sale_items.*.product_item.appointment_id.required_if' => 'O agendamento de cada item de venda de agendamento é obrigatório.',
            'sale_items.*.product_item.appointment_id.exists' => 'O agendamento de cada item de venda de agendamento deve existir.',
        ];
    }
}
