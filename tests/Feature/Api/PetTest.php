<?php

use App\Models\Pet;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

test('A pet can be saved', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);
    $data = [
        'name' => 'Belinha',
        'gender' => 'female',
        'specie' => 'dog',
        'race' => 'Maltês',
        'height' => 1.5,
        'weight' => 1.0,
        'castrated' => true,
        'birth' => fake()->date,
    ];

    $response = $this->postJson(route('api.customers.pets.store'), $data);

    $petId = $response->json('id');
    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Criado com sucesso',
            'id' => $petId,
        ]);

    $this->assertDatabaseHas('pets', [
        'id' => $petId,
        'name' => 'Belinha',
        'gender' => 'female',
        'specie' => 'dog',
        'race' => 'Maltês',
        'height' => 1.5,
        'weight' => 1.0,
        'castrated' => true,
    ]);
});

test('A pet cannot be saved with invalid information', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);
    $data = [
        'name' => 12,
        'gender' => 'female',
        'specie' => 'dog',
        'race' => 'Maltês',
        'height' => 'text',
        'weight' => 1.0,
        'castrated' => true,
        'birth' => fake()->date,
    ];

    $response = $this->postJson(route('api.customers.pets.store'), $data);

    $response->assertStatus(422)
        ->assertJson([
            'errors' => [
                'name' => ['O nome do pet deve ser uma string.'],
                'height' => ['A altura do pet deve ser um número.'],
            ],
        ]);
});

test('A pet cannot be saved with your required information', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);
    $data = [];

    $response = $this->postJson(route('api.customers.pets.store'), $data);

    $response->assertStatus(422)
        ->assertJson([
            'errors' => [
                'name' => [
                    'O nome do pet é obrigatório.',
                ],
                'gender' => [
                    'O gênero do pet é obrigatório.',
                ],
                'specie' => [
                    'A espécie do pet é obrigatória.',
                ],
                'race' => [
                    'A raça do pet é obrigatória.',
                ],
            ],
        ]);
});

test('Pets can be loaded', function () {
    $user = User::factory()->hasCustomer()->create();
    Pet::factory()->count(3)->for($user->customer)->create();
    Sanctum::actingAs($user, ['customer']);

    $response = $this->getJson(route('api.customers.pets.index'));

    $response->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json->has('data', 3)
                ->has(
                    'data.0',
                    fn ($json) => $json->whereType('id', 'integer')
                        ->whereType('customer_id', 'integer')
                        ->whereType('name', 'string')
                        ->whereType('gender', 'string')
                        ->whereType('specie', 'string')
                        ->whereType('race', 'string')
                        ->whereType('height', 'string')
                        ->whereType('weight', 'string')
                        ->whereType('castrated', 'boolean')
                        ->whereType('birth', 'string')
                        ->whereType('created_at', 'string')
                        ->whereType('updated_at', 'string')
                )
        );
});

test('A pet must be searched by id', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);

    $r = $this->postJson(route('api.customers.pets.store'), Pet::factory()->make()->toArray());
    $pet = $user->customer->pets()->find($r->json('id'));

    $response = $this->getJson(route('api.customers.pets.show', ['pet' => $pet->id]));

    $response->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                fn ($json) => $json->where('id', $pet->id)
                    ->where('customer_id', $pet->customer_id)
                    ->where('name', $pet->name)
                    ->where('gender', $pet->gender)
                    ->where('specie', $pet->specie)
                    ->where('race', $pet->race)
                    ->where('height', "{$pet->height}")
                    ->where('weight', "{$pet->weight}")
                    ->where('castrated', $pet->castrated)
                    ->where('birth', $pet->birth)
                    ->where('created_at', $pet->created_at->toISOString())
                    ->where('updated_at', $pet->updated_at->toISOString())
            )
        );
});

test('Searching for a non-existing pet returns an error', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);
    $response = $this->getJson(route('api.customers.pets.show', ['pet' => '9999999']));

    $response->assertStatus(404)
        ->assertJson([
            'error' => 'Pet não encontrado.',
        ]);
});

test('A pet can be updated', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);

    $r = $this->postJson(route('api.customers.pets.store'), Pet::factory()->make()->toArray());
    $pet = $user->customer->pets()->find($r->json('id'));

    $response = $this->putJson(route('api.customers.pets.update', ['pet' => $pet->id]), [
        'name' => 'Spike',
        'gender' => 'male',
    ]);

    $response->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json->where('message', 'Atualizado com sucesso')
                ->etc()
        );

    $this->assertDatabaseHas('pets', [
        'id' => $pet->id,
        'name' => 'Spike',
        'gender' => 'male',
    ]);
});

test('A pet cannot be updated with invalid information', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);

    $r = $this->postJson(route('api.customers.pets.store'), Pet::factory()->make()->toArray());
    $pet = $user->customer->pets()->find($r->json('id'));

    $response = $this->putJson(route('api.customers.pets.update', ['pet' => $pet->id]), [
        'name' => '',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'errors' => [
                'name' => [
                    'O nome do pet deve ser uma string.',
                    'O nome do pet precisa ter pelo menos 2 caracteres.',
                ],
            ],
        ]);
});

test('Updating a non-existing pet returns error', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);

    $response = $this->putJson(route('api.customers.pets.update', ['pet' => '9999999']), [
        'name' => 'NewName',
    ]);

    $response->assertStatus(404)
        ->assertJson([
            'error' => 'Pet não encontrado.',
        ]);
});

test('A pet can be deleted', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);

    $r = $this->postJson(route('api.customers.pets.store'), Pet::factory()->make()->toArray());
    $pet = $user->customer->pets()->find($r->json('id'));

    $response = $this->deleteJson(route('api.customers.pets.destroy', ['pet' => $pet->id]));

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Pet excluído com sucesso.',
        ]);

    $this->assertDatabaseMissing('pets', ['id' => $pet->id]);
});

test('Trying to delete a non-existing pet returns error', function () {
    $user = User::factory()->hasCustomer()->create();
    Sanctum::actingAs($user, ['customer']);
    $response = $this->deleteJson(route('api.customers.pets.destroy', ['pet' => '999999']));

    $response->assertStatus(404)
        ->assertJson([
            'error' => 'Pet não encontrado.',
        ]);
});
