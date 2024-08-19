<?php

use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

it('can sign up a new customer with address', function () {
    $data = User::factory()->make()->toArray();
    $data = array_merge($data, Customer::factory()->make()->toArray());
    $data['password'] = 'password123';
    $data['password_confirmation'] = 'password123';
    $data['address'] = Address::factory()->make()->toArray();

    $response = $this->postJson(route('api.customers.signup'), $data);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
    ]);

    $this->assertDatabaseHas('customers', [
        'phone_number' => $data['phone_number'],
    ]);

    $this->assertDatabaseHas('addresses', [
        'cep' => $data['address']['cep'],
        'street' => $data['address']['street'],
        'number' => $data['address']['number'],
        'district' => $data['address']['district'],
        'city' => $data['address']['city'],
        'complement' => $data['address']['complement'],
        'state' => $data['address']['state'],
    ]);
});

it('can sign up a new customer without address', function () {
    $data =  User::factory()->make()->toArray();
    $data = array_merge($data, Customer::factory()->make()->toArray());
    $data['password'] = 'password123';
    $data['password_confirmation'] = 'password123';

    $response = $this->postJson(route('api.customers.signup'), $data);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
        'cpf' => $data['cpf'],
    ]);

    $this->assertDatabaseHas('customers', [
        'phone_number' => $data['phone_number'],
    ]);

    $this->assertDatabaseMissing('addresses', [
        'user_id' => User::where('email', $data['email'])->first()->id,
    ]);
});

it('can log in a customer and return a token', function () {
    $password = 'password123';
    User::factory()->hasCustomer()->create([
        'email' => 'customer@example.com',
        'password' => Hash::make($password),
    ]);

    $response = $this->postJson(route('api.customers.login'), [
        'email' => 'customer@example.com',
        'password' => $password,
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['token']);
});

it('fails to log in with invalid credentials', function () {
    User::factory()->hasCustomer()->create([
        'email' => 'customer@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson(route('api.customers.login'), [
        'email' => 'customer@example.com',
        'password' => 'wrongpassword',
    ]);

    $response
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthorized']);
});

it('fails to log in a non-customer user', function () {
    $password = 'password123';
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => Hash::make($password),
    ]);

    $response = $this->postJson(route('api.customers.login'), [
        'email' => 'user@example.com',
        'password' => $password,
    ]);

    $response
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthorized']);
});

it('can log out the authenticated customer', function () {
    $user = User::factory()->hasCustomer()->create();

    Sanctum::actingAs($user, ['customer']);

    $response = $this->postJson(route('api.customers.logout'));

    $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Logged out']);
});

it('fails to log out if not authenticated', function () {
    $response = $this->postJson(route('api.customers.logout'));

    $response->assertStatus(401);
});
