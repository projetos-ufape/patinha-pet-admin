<?php

use App\Models\Pet;
use Illuminate\Testing\Fluent\AssertableJson;

test("Pets can be loaded", function () {
  $pets = Pet::factory()->count(3)->create();

  $response = $this->getJson('api/pets');
  $response->assertStatus(200)
    ->assertJson(
      fn(AssertableJson $json) =>
      $json->has('data', 3)
        ->has(
          'data.0',
          fn($json) =>
          $json->whereType('id', 'integer')
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

test("A pet can be saved", function () {
  $data = [
    'name' => "Belinha",
    'gender' => 'female',
    'specie' => 'dog',
    'race' => 'Maltês',
    'height' => 1.5,
    'weight' => 1.0,
    'castrated' => true,
    'birth' => fake()->date
  ];

  $response = $this->postJson('/api/pets', $data);

  $response->assertStatus(201)
    ->assertJson([
      'message' => "Criado com sucesso",
    ]);
});

test("A pet cannot be saved with invalid information", function () {
  $data = [
    'name' => 12,
    'gender' => 'female',
    'specie' => 'dog',
    'race' => 'Maltês',
    'height' => "text",
    'weight' => 1.0,
    'castrated' => true,
    'birth' => fake()->date
  ];

  $response = $this->postJson('/api/pets', $data);

  $response->assertStatus(422)
    ->assertJson([
      'errors' => [
        'name' => ["O nome do pet deve ser uma string."],
        'height' => ["A altura do pet deve ser um número."]
      ],
    ]);
});

test("A pet cannot be saved with your required information", function () {
  $data = [];

  $response = $this->postJson('/api/pets', $data);

  $response->assertStatus(422)
    ->assertJson([
      'errors' => [
        "name" => [
          "O nome do pet é obrigatório."
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

test("A pet must be searched by id", function () {
  $pet = Pet::factory()->create();
  $response = $this->getJson("api/pets/{$pet->id}");

  $response->assertStatus(200)
    ->assertJson(
      fn(AssertableJson $json) =>
      $json->has(
        'data',
        fn($json) =>
        $json->where('id', $pet->id)
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

test("Searching for a non-existing pet returns an error", function () {
  $response = $this->getJson('/api/pets/999999');

  $response->assertStatus(404)
    ->assertJson([
      'error' => 'Pet não encontrado.',
    ]);
});

test("A pet can be updated", function () {
  $pet = Pet::factory()->create([
    'name' => "Belinha",
    'gender' => 'female',
    'specie' => 'dog',
    'race' => 'Maltês',
    'height' => 1.5,
    'weight' => 1.0,
    'castrated' => true,
    'birth' => fake()->date,
  ]);

  $response = $this->putJson("api/pets/{$pet->id}", [
    'name' => 'Spike',
    'gender' => 'male'
  ]);

  $response->assertStatus(200)
    ->assertJson(
      fn(AssertableJson $json) =>
      $json->where('message', 'Atualizado com sucesso')
        ->etc()
    );

  $this->assertDatabaseHas('pets', [
    'id' => $pet->id,
    'name' => 'Spike',
    'gender' => 'male',
  ]);
});

test("A pet cannot be updated with invalid information", function () {
  $pet = Pet::factory()->create();

  $response = $this->putJson("api/pets/{$pet->id}", [
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

test("Updating a non-existing pet returns error", function () {
  $response = $this->putJson('/api/pets/999999', [
    'name' => 'NewName',
  ]);

  $response->assertStatus(404)
    ->assertJson([
      'error' => 'Pet não encontrado.',
    ]);
});

test("A pet can be deleted", function () {
  $pet = Pet::factory()->create();

  $response = $this->deleteJson('/api/pets/' . $pet->id);

  $response->assertStatus(200)
    ->assertJson([
      'message' => 'Pet excluído com sucesso.',
    ]);

  $this->assertDatabaseMissing('pets', ['id' => $pet->id]);
});

test("Trying to delete a non-existing pet returns error", function () {
  $response = $this->deleteJson('/api/pets/999999');

  $response->assertStatus(404)
    ->assertJson([
      'error' => 'Pet não encontrado.',
    ]);
});