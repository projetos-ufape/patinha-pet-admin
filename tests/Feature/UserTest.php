<?php

use App\Models\Address;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('index users', function () {
	$user = User::factory()->create();

    $response = $this->get('/user');

	$response->assertJson([[
		'id' => $user->id,
	]]); // remove later
});

test('index no users', function () {
	$response = $this->get('/user');

	$response->assertExactJson([]); // remove later
});

test('store user', function () {
    $response = $this->post('/user', [
        'name' => 'aaaaa',
        'email' => 'aaaaa@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
		'cpf' => '000.000.000-00',
		'salary' => 1000.00,
		'admission_date' => '2001-01-01',
		'state' => 'pernambuco',
		'city' => 'some city',
		'district' => 'some district',
		'street' => 'some street',
		'number' => 0,
		'complement' => 'some complement',
		'cep' => '00000-000',
    ]);

    $response->assertJson([
		'email' => 'aaaaa@email.com',
	]); // remove later
});

test('store user with invalid email', function () {
    $response = $this->post('/user', [
        'name' => 'aaaaa',
        'email' => 'aaaaa',
        'password' => 'password',
        'password_confirmation' => 'password',
		'cpf' => '000.000.000-00',
		'salary' => 1000.00,
		'admission_date' => '2001-01-01',
		'state' => 'pernambuco',
		'city' => 'some city',
		'district' => 'some district',
		'street' => 'some street',
		'number' => 0,
		'complement' => 'some complement',
		'cep' => '00000-000',
    ]);

	$response->assertStatus(302);
});

test('show user', function () {
	$user = User::factory()->create();

    $response = $this->get('/user/'.$user->id);

	$response->assertJson([
		'id' => $user->id,
	]); // remove later
});

test('show no user', function () {
	$response = $this->get('/user/0');

	$response->assertJson([]); // remove later
});

test('update user', function () {
	$user = User::factory()->create(['email' => 'aaaaa@gmail.com']);

	Address::factory()->create(['user_id' => $user->id]);

    $response = $this->patch('/user/'.$user->id, [
        'name' => 'aaaaa',
        'email' => 'bbbbb@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
		'cpf' => '000.000.000-00',
		'salary' => 1000.00,
		'admission_date' => '2001-01-01',
		'state' => 'pernambuco',
		'city' => 'some city',
		'district' => 'some district',
		'street' => 'some street',
		'number' => 0,
		'complement' => 'some complement',
		'cep' => '00000-000',
		'id' => $user->id
    ]);

	$response->assertJson([
		'email' => 'bbbbb@email.com',
	]); // remove later
});

test('update inexistent user', function () {

    $response = $this->patch('/user/0', [
        'name' => 'aaaaa',
        'email' => 'bbbbb@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
		'cpf' => '000.000.000-00',
		'salary' => 1000.00,
		'admission_date' => '2001-01-01',
		'state' => 'pernambuco',
		'city' => 'some city',
		'district' => 'some district',
		'street' => 'some street',
		'number' => 0,
		'complement' => 'some complement',
		'cep' => '00000-000',
		'id' => '0'
    ]);
	
	$response->assertStatus(500);
});

test('destroy user', function () {
	$user = User::factory()->create();

    $response = $this->delete('/user/'.$user->id);

	$response->assertJson([
		'id' => $user->id,
	]); // remove later
});

test('destroy inexistent user', function () {
    $response = $this->delete('/user/0');

	$response->assertStatus(500);
});