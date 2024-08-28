<?php

use App\Models\Address;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can update a customer with only one attribute', function () {
  $user = User::factory()->hasCustomer()->create([
      'name' => 'Original Name',
      'email' => 'original@example.com',
  ]);

  Sanctum::actingAs($user, ['customer']);

  $newName = 'Updated Name';

  $response = $this->patchJson(route('api.customers.update'), [
      'name' => $newName,
  ]);

  $response->assertStatus(200)
      ->assertJson(['message' => 'Atualizado com sucesso']);

  $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => $newName,
      'email' => 'original@example.com', 
  ]);

    $this->assertDatabaseHas('customers', [
      'user_id' => $user->id,
      'phone_number' => $user->customer->phone_number, 
  ]);
});

it('can update a customer with only the email attribute', function () {
  $user = User::factory()->hasCustomer()->create([
      'name' => 'Original Name',
      'email' => 'original@example.com',
  ]);

  Sanctum::actingAs($user, ['customer']);

  $newEmail = 'updated@example.com';

  $response = $this->patchJson(route('api.customers.update'), [
      'email' => $newEmail,
  ]);

  $response->assertStatus(200)
      ->assertJson(['message' => 'Atualizado com sucesso']);

  $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => 'Original Name',
      'email' => $newEmail,
  ]);

  $this->assertDatabaseHas('customers', [
      'user_id' => $user->id,
      'phone_number' => $user->customer->phone_number,
  ]);
});

it('can update a customer with a full address', function () {
  $user = User::factory()->hasCustomer()->create();
  $address = Address::factory()->make()->toArray();

  Sanctum::actingAs($user, ['customer']);

  $response = $this->patchJson(route('api.customers.update'), [
      'address' => $address,
  ]);

  $response->assertStatus(200)
      ->assertJson(['message' => 'Atualizado com sucesso']);

  $this->assertDatabaseHas('addresses', [
      'user_id' => $user->id,
      'cep' => $address['cep'],
      'street' => $address['street'],
      'number' => $address['number'],
      'district' => $address['district'],
      'city' => $address['city'],
      'complement' => $address['complement'],
      'state' => $address['state'],
  ]);
});

it('can update a customer with multiple attributes', function () {
  $user = User::factory()->hasCustomer()->create();

  Sanctum::actingAs($user, ['customer']);

  $response = $this->patchJson(route('api.customers.update'), [
      'name' => 'Updated Name',
      'phone_number' => '09876543210',
  ]);

  $response->assertStatus(200)
      ->assertJson(['message' => 'Atualizado com sucesso']);

  $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => 'Updated Name',
  ]);

  $this->assertDatabaseHas('customers', [
      'user_id' => $user->id,
      'phone_number' => '09876543210',
  ]);
});


it('fails to update a customer with no attributes provided', function () {
  $user = User::factory()->hasCustomer()->create();

  Sanctum::actingAs($user, ['customer']);

  $response = $this->patchJson(route('api.customers.update'), []);

  $response->assertStatus(422); // Expecting a validation error

  // Verifica se não houve mudanças nos dados do usuário
  $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
  ]);

  $this->assertDatabaseHas('customers', [
      'user_id' => $user->id,
      'phone_number' => $user->customer->phone_number,
  ]);
});
