<?php

namespace App\Http\Controllers;

use App\Enums\AddressState;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

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
  public function create(Request $request)
  {
    return view('employees.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'cpf' => ['required', 'string'],
      'salary' => ['required', 'numeric'],
      'admission_date' => ['required', 'date', 'date_format:Y-m-d'],
      'address' => ['sometimes', 'array'],
      'address.cep' => ['sometimes', 'size:8'],
      'address.street' => ['required_with:address', 'min:3', 'max:50'],
      'address.number' => ['required_with:address', 'string', 'min:1', 'max:10'],
      'address.district' => ['required_with:address', 'min:3', 'max:50'],
      'address.city' => ['required_with:address', 'min:3', 'max:50'],
      'address.complement' => ['string', 'max:50'],
      'address.state' => ['required_with:address', Rule::enum(AddressState::class)],
    ]);

    DB::transaction(function () use ($data) {
      $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'cpf' => $data['cpf'],
      ]);

      $user->employee()->create([
        'salary' => $data['salary'],
        'admission_date' => $data['admission_date'],
      ]);

      if (!empty($data['address'])) {
        $user->address()->create($data['address']);
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
      $employee = Employee::findOrFail($id);
      $user = User::with('employee')->findOrFail($employee->user_id);
      return view('employees.edit', [
          'employee' => $employee,
          'user' => $user,
      ]);
  }
  
  
  
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employee)
  {
    $employee->load('user.address');
    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $employee->user->id],
      'password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
      'cpf' => ['required', 'string'],
      'salary' => ['required', 'numeric'],
      'admission_date' => ['required', 'date', 'date_format:Y-m-d'],
      'address' => ['nullable', 'array'],
      'address.cep' => ['sometimes', 'size:8'],
      'address.street' => ['required_with:address', 'min:3', 'max:50'],
      'address.number' => ['required_with:address', 'string', 'min:1', 'max:10'],
      'address.district' => ['required_with:address', 'min:3', 'max:50'],
      'address.city' => ['required_with:address', 'min:3', 'max:50'],
      'address.complement' => ['string', 'max:50'],
      'address.state' => ['required_with:address', Rule::enum(AddressState::class)],
    ]);

    DB::transaction(function () use ($data, $employee) {
      $userData = [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
      ];

      if (isset($data['password'])) {
        $userData['password'] = Hash::make($data['password']);
      }
      $employee->user->update($userData);

      $employee->update([
        'salary' => $data['salary'],
        'admission_date' => $data['admission_date'],
      ]);

      if (is_null($data['address'])) {
        $employee->user->address->delete();
      } else if (isset($data['address'])) {
        $employee->user->address()->updateOrCreate(
          ['user_id' => $employee->user->id],
          $data['address']
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
