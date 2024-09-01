<?php

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('db:seed', ['--class' => 'PermissionsSeeder']);
    Artisan::call('db:seed', ['--class' => 'RolesSeeder']);
});

it('can list customers', function () {
    // TODO: Implement test
})->skip();

it('can create a new customer', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');

    $data = [
        'name' => 'Peter Parker',
        'cpf' => '11345484565',
        'phone_number' => '87981245685',
        'email' => 'spider@ny.com',
        'password' => 'sinister_sextet@down',
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('customers.store'), $data);

    $response
        ->assertRedirect(route('customers.index'))
        ->assertSessionHas('success', 'Cliente cadastrado com sucesso.');

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
    ]);

    $this->assertDatabaseHas('customers', [
        'phone_number' => $data['phone_number'],
    ]);
});

it('can update a customer', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $user = User::factory()->hasCustomer()->create();
    $customer = $user->customer;

    $data = [
        'name' => 'Jane Doe',
        'phone_number' => '1234567890',
    ];

    $this->actingAs($admin, 'web')
        ->put(route('customers.update', $customer), $data)
        ->assertRedirect(route('customers.index'))
        ->assertSessionHas('success', 'Cliente atualizado com sucesso.');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $data['name'],
    ]);

    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'phone_number' => $data['phone_number'],
    ]);
});

it('can delete a customer', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $customer = Customer::factory()->create();

    $this->actingAs($admin, 'web')
        ->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'))
        ->assertSessionHas('success', 'Cliente excluído com sucesso.');

    $this->assertDatabaseMissing('users', [
        'id' => $customer->id,
    ]);

    $this->assertDatabaseMissing('customers', [
        'id' => $customer->id,
    ]);
});

it('employee can retrieve customer history', function () {
    $employee = Employee::factory()->create();
    $employee->assignRole('admin');
    $customer = Customer::factory()->create();
    $appointments = Appointment::factory()->for($customer)->count(3)->create();

    $response = $this->actingAs($employee->user, 'web')
        ->get(route('customers.history', $customer->id));

    $response->assertStatus(200);
    $response->assertViewIs('customers.history');
    $response->assertViewHas('appointments');
    $appointmentsInView = $response->viewData('appointments');

    $this->assertCount($appointments->count(), $appointmentsInView);

    $appointments->each(function ($appointment) use ($appointmentsInView) {
        $this->assertTrue($appointmentsInView->contains('id', $appointment->id));
    });
});

it('displays no results found message when customer has no appointments', function () {
    $employee = Employee::factory()->create();
    $employee->assignRole('admin');
    $customer = Customer::factory()->create();
    $response = $this->actingAs($employee->user, 'web')
        ->get(route('customers.history', $customer->id));

    $response->assertStatus(200);
    $response->assertViewIs('customers.history');
    $response->assertSee('Nenhum resultado encontrado.');
    $this->assertDatabaseCount('appointments', 0);
});
