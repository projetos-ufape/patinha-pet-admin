<?php

use App\Models\Address;
use App\Models\Employee;
use App\Models\User;

function make_employee_without_address()
{
    $employee = Employee::factory()->make();
    $data = User::factory()->make()->toArray();
    $data['name'] = 'Peter Parker';
    $data['admission_date'] = $employee->admission_date->format('Y-m-d');
    $data['salary'] = (float) ($employee['salary']);
    $data['password'] = 'password';
    $data['password_confirmation'] = $data['password'];

    return $data;
}

it('can store a new employee with address', function () {
    $admin = User::factory()->create();

    $employee = Employee::factory()->make();
    $data = User::factory()->make()->toArray();
    $data['admission_date'] = $employee->admission_date->format('Y-m-d');
    $data['salary'] = $employee->salary;
    $data['password'] = 'password';
    $data['password_confirmation'] = $data['password'];
    $data['address'] = Address::factory()->make()->toArray();

    $response = $this
        ->actingAs($admin, 'web')
        ->post(route('employees.store'), $data);

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
    ]);

    $this->assertDatabaseHas('employees', [
        'salary' => $data['salary'],
        'admission_date' => $data['admission_date'],
    ]);

    $this->assertDatabaseHas('addresses', [
        'cep' => $data['address']['cep'],
        'street' => $data['address']['street'],
        'number' => $data['address']['number'],
        'district' => $data['address']['district'],
        'city' => $data['address']['city'],
        'state' => $data['address']['state'],
    ]);

    $response
        ->assertRedirect(route('employees.index'))
        ->assertSessionHas('success', 'Usuário cadastrado com sucesso.');
});

it('can store a new employee without address', function () {
    $admin = User::factory()->create();
    $data = make_employee_without_address();

    $response = $this
        ->actingAs($admin, 'web')
        ->post(route('employees.store'), $data);

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
    ]);

    $this->assertDatabaseHas('employees', [
        'salary' => $data['salary'],
        'admission_date' => $data['admission_date'],
    ]);

    $response
        ->assertRedirect(route('employees.index'))
        ->assertSessionHas('success', 'Usuário cadastrado com sucesso.');
});

it('can update an existing employee and address', function () {
    $admin = User::factory()->create();
    $user = User::factory()
        ->has(Employee::factory())
        ->has(Address::factory())
        ->create();

    $updatedEmployeeData = Employee::factory()->make();
    $updatedData = User::factory()->make()->toArray();
    $updatedData['admission_date'] = $updatedEmployeeData->admission_date->format('Y-m-d');
    $updatedData['salary'] = $updatedEmployeeData->salary;
    $updatedData['address'] = Address::factory()->make()->toArray();

    $response = $this->actingAs($admin, 'web')
        ->put(route('employees.update', $user->employee), $updatedData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $updatedData['name'],
        'email' => $updatedData['email'],
        'cpf' => $updatedData['cpf'],
    ]);

    $this->assertDatabaseHas('employees', [
        'id' => $user->employee->id,
        'salary' => $updatedData['salary'],
        'admission_date' => $updatedData['admission_date'],
    ]);

    $this->assertDatabaseHas('addresses', [
        'cep' => $updatedData['address']['cep'],
        'street' => $updatedData['address']['street'],
        'number' => $updatedData['address']['number'],
        'district' => $updatedData['address']['district'],
        'city' => $updatedData['address']['city'],
        'state' => $updatedData['address']['state'],
    ]);

    $response
        ->assertRedirect(route('employees.index'))
        ->assertSessionHas('success', 'Usuário atualizado com sucesso.');
});

it('can remove the address from an existing employee', function () {
    $admin = User::factory()->create();
    $user = User::factory()
        ->has(Employee::factory())
        ->has(Address::factory())
        ->create();

    $updatedEmployeeData = Employee::factory()->make();
    $updatedData = User::factory()->make()->toArray();
    $updatedData['admission_date'] = $updatedEmployeeData->admission_date->format('Y-m-d');
    $updatedData['salary'] = $updatedEmployeeData->salary;
    $updatedData['address'] = null;

    $response = $this->actingAs($admin, 'web')
        ->put(route('employees.update', $user->employee), $updatedData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $updatedData['name'],
        'email' => $updatedData['email'],
        'cpf' => $updatedData['cpf'],
    ]);

    $this->assertDatabaseHas('employees', [
        'id' => $user->employee->id,
        'salary' => $updatedData['salary'],
        'admission_date' => $updatedData['admission_date'],
    ]);

    $this->assertDatabaseMissing('addresses', [
        'user_id' => $user->id,
    ]);

    $response
        ->assertRedirect(route('employees.index'))
        ->assertSessionHas('success', 'Usuário atualizado com sucesso.');
});

it('on update, can create an address for an employee who does not have one', function () {
    $admin = User::factory()->create();
    $data = make_employee_without_address();
    $this->actingAs($admin, 'web')->post(route('employees.store'), $data);
    $user = User::where('email', $data['email'])->first();
    $updatedData = make_employee_without_address();
    $updatedData['address'] = Address::factory()->make()->toArray();
    $response = $this->actingAs($admin, 'web')
        ->put(route('employees.update', $user->employee), $updatedData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $updatedData['name'],
        'email' => $updatedData['email'],
        'cpf' => $updatedData['cpf'],
    ]);

    $this->assertDatabaseHas('employees', [
        'id' => $user->employee->id,
        'salary' => $updatedData['salary'],
        'admission_date' => $updatedData['admission_date'],
    ]);

    $this->assertDatabaseHas('addresses', [
        'user_id' => $user->id,
    ]);

    $response
        ->assertRedirect(route('employees.index'))
        ->assertSessionHas('success', 'Usuário atualizado com sucesso.');
});
