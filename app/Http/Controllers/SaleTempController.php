<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Customer;
use App\Models\Product;

class SaleTempController extends Controller
{
    public function create()
    {
        $products = Product::all();
        $filter = function ($query) {
            $query->where('status', '!=', AppointmentStatus::Canceled);
            // TODO: adicionar filtro de "ainda não foi registrado a venda"
        };
        $pendingAppointmentsByCustomer = Customer::select('id', 'user_id')
            ->with(['user:id,name', 'appointments' => $filter])
            ->whereHas('appointments', $filter)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->user->name,
                    'appointments' => $customer->appointments->map(function ($appointment) {
                        return [
                            'id' => $appointment->id,
                            'service_name' => $appointment->service->name, // Carregando o nome do serviço
                            'date' => $appointment->start_time,
                            'pet_name' => $appointment->pet->name,
                            'value' => $appointment->service->price,
                        ];
                    }),
                ];
            });

        return view('commercial.scheduling.index', compact('products', 'pendingAppointmentsByCustomer'));
    }
}
