<?php

namespace App\Http\Controllers;

use App\Enums\AddressState;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $users = User::has('customer')->get();

        return view('customers.index', ['customers' => $customers, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = AddressState::values();

        return view('customers.create', ['states' => $states]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'password' => bcrypt($data['password']),
            ]);

            $user->customer()->create([
                'phone_number' => $data['phone_number'],
            ]);
        });

        return Redirect::route('customers.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customer.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $states = AddressState::values();

        return view('customers.edit', ['customer' => $customer, 'states' => $states]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $customer) {
            $customer->user->updateOrFail([
                'name' => $data['name'],
            ]);

            $customer->updateOrFail([
                'phone_number' => $data['phone_number'],
            ]);
        });

        return Redirect::route('customers.index', [$customer])->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->user->deleteOrFail();

        return Redirect::route('customers.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
