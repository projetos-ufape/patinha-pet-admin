<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Service;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers =  Customer::all();
        $pets = Pet::all();
        $services = Service::all();
        $status = AppointmentStatus::values();

        return view('appointments.create', compact('customers', 'pets', 'services', 'status'));
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->create($request->validated());

        return redirect()->route('appointments.index')->with('success', 'Registro de atendimento criado com sucesso.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //    return view('appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $customers = Customer::all();
        $pets = Pet::all();
        $services = Service::all();
        $status = AppointmentStatus::values();

        return view('appointments.create', compact('appointment', 'customers', 'pets', 'services', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.index')->with('success', 'Registro de atendimento atualizado com sucesso.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);

        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Registro de atendimento removido com sucesso.'); 
    }
}
