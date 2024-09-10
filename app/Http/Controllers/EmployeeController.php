<?php

namespace App\Http\Controllers;

use App\Enums\AddressState;
use App\Enums\EmployeeType;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::with('employee')->whereHas('employee')->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = AddressState::values();
        $types = EmployeeType::cases();

        return view('employees.create', ['states' => $states, 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'cpf' => $validatedData['cpf'],
            ]);

            $user->employee()->create([
                'salary' => $validatedData['salary'],
                'admission_date' => $validatedData['admission_date'],
            ]);

            $user->assignRole($validatedData['type']);

            if (! empty($validatedData['address'])) {
                $user->address()->create($validatedData['address']);
            }
        });

        return redirect()->route('employees.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $states = AddressState::values();
        $employee = Employee::findOrFail($id);
        $user = User::with('employee')->findOrFail($employee->user_id);

        return view('employees.edit', [
            'employee' => $employee,
            'user' => $user,
            'states' => $states,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->load('user.address');
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $employee) {
            $userValidatedData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'cpf' => $validatedData['cpf'],
            ];

            if (isset($validatedData['password'])) {
                $userValidatedData['password'] = Hash::make($validatedData['password']);
            }
            $employee->user->update($userValidatedData);

            $employee->update([
                'salary' => $validatedData['salary'],
                'admission_date' => $validatedData['admission_date'],
            ]);

            if (is_null($validatedData['address'])) {
                $employee->user->address->delete();
            } elseif (isset($validatedData['address'])) {
                $employee->user->address()->updateOrCreate(
                    ['user_id' => $employee->user->id],
                    $validatedData['address']
                );
            }
        });

        return redirect()->route('employees.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::with('employee')->findOrFail($employee->user_id);
        $user->delete();

        return redirect()->route('employees.index')->with('success', 'Usuário Excluido com sucesso.');
    }
}
