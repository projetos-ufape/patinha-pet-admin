<?php

use App\Enums\AddressState;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
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

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
