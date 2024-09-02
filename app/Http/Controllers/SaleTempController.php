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
            $query->where('status', "!=", AppointmentStatus::Canceled);
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
                    'appointments' => $customer->appointments
                ];
            });
        return view('commercial.scheduling.index', compact('products', 'pendingAppointmentsByCustomer'));
    }
}
