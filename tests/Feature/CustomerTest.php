<?php

use App\Models\User;

it('can list customers', function () {
    // TODO: Implement test
})->skip();

it('can create a new customer', function () {
    $admin = User::factory()->create();

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
    $admin = User::factory()->create();
    $user = User::factory()->hasCustomer()->create();
    $customer = $user->customer;

    $data = [
        'name' => 'Jane Doe',
        'phone_number' => '1234567890',
    ];

    $this->actingAs($admin, 'web')
        ->put(route('customers.update', $customer), $data)
        ->assertRedirect(route('customers.edit', $customer))
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
    $admin = User::factory()->create();
    $user = User::factory()->hasCustomer()->create();
    $customer = $user->customer;

    $this->actingAs($admin, 'web')
        ->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'))
        ->assertSessionHas('success', 'Cliente excluído com sucesso.');

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);

    $this->assertDatabaseMissing('customers', [
        'id' => $customer->id,
    ]);
});
