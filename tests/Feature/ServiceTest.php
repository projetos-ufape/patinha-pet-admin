<?php

use App\Models\User;
use App\Models\Service;


it('can list services', function () {
    $admin = User::factory()->create();

    $response = $this->actingAs($admin, 'web')
        ->get(route('services.index'));

    $response->assertOk(); // Verifica se a resposta foi 200 (OK)
})->skip();

it('can create a new service', function () {
    $admin = User::factory()->create();

    $data = [
        'name' => 'Banho e Tosa',
        'description' => 'Serviço completo de banho e tosa',
        'price' => 79.90,
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response
        ->assertRedirect(route('services.index'))
        ->assertSessionHas('success', 'Serviço cadastrado com sucesso.');

    $this->assertDatabaseHas('services', [
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
    ]);
});

it('can update a service', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $data = [
        'name' => 'Banho e Tosa Deluxe',
        'description' => 'Banho e tosa com produtos premium',
        'price' => 99.90,
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data)
        ->assertRedirect(route('services.edit', $service))
        ->assertSessionHas('success', 'Serviço atualizado com sucesso.');

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
    ]);
});

it('can delete a service', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $response = $this->actingAs($admin, 'web')
        ->delete(route('services.destroy', $service))
        ->assertRedirect(route('services.index'))
        ->assertSessionHas('success', 'Serviço removido com sucesso.');

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});

it('cannot create a service without a name', function () {
    $admin = User::factory()->create();
    $data = [
        'description' => 'Serviço sem nome',
        'price' => 50.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço é obrigatório.';
    });
});

it('cannot create a service with a non-string name', function () {
    $admin = User::factory()->create();
    $data = [
        'name' => 12345,
        'description' => 'Descrição com nome não-string',
        'price' => 60.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço deve ser uma string.';
    });
});

it('cannot create a service with a name longer than 255 characters', function () {
    $admin = User::factory()->create();
    $data = [
        'name' => str_repeat('a', 256),
        'description' => 'Descrição com nome muito longo',
        'price' => 70.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço não pode ter mais que 255 caracteres.';
    });
});

it('cannot create a service without a price', function () {
    $admin = User::factory()->create();
    $data = [
        'name' => 'Serviço Sem Preço',
        'description' => 'Descrição sem preço',

    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço é obrigatório.';
    });
});

it('cannot create a service with a non-numeric price', function () {
    $admin = User::factory()->create();
    $data = [
        'name' => 'Serviço com Preço Não Numérico',
        'description' => 'Descrição com preço inválido',
        'price' => 'not a number',
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço deve ser um valor numérico.';
    });
});

it('cannot create a service with a negative price', function () {
    $admin = User::factory()->create();
    $data = [
        'name' => 'Serviço com Preço Negativo',
        'description' => 'Descrição com preço negativo',
        'price' => -10.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->post(route('services.store'), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço deve ser um valor positivo.';
    });
});

it('cannot update a service without a name', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $data = [
        'description' => 'Descrição sem nome',
        'price' => 50.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço é obrigatório.';
    });
});

it('cannot update a service with a non-string name', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $data = [
        'name' => 12345, 
        'description' => 'Descrição com nome não-string',
        'price' => 60.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço deve ser uma string.';
    });
});

it('cannot update a service with a name longer than 255 characters', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $data = [
        'name' => str_repeat('a', 256),
        'description' => 'Descrição com nome muito longo',
        'price' => 70.00,
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('name') && $errors->first('name') === 'O nome do serviço não pode ter mais que 255 caracteres.';
    });
    
});

it('cannot update a service without a price', function () {
    $admin = User::factory()->create();
    $service = Service::factory()->create();

    $data = [
        'name' => 'Serviço Sem Preço',
        'description' => 'Descrição sem preço',
        
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço é obrigatório.';
    });
});

it('cannot update a service with a non-numeric price', function () {
    $admin = User::factory()->create();
    $service = \App\Models\Service::factory()->create();

    $data = [
        'name' => 'Serviço com Preço Não Numérico',
        'description' => 'Descrição com preço inválido',
        'price' => 'not a number', 
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço deve ser um valor numérico.';
    });
});

it('cannot update a service with a negative price', function () {
    $admin = User::factory()->create();
    $service = \App\Models\Service::factory()->create();

    $data = [
        'name' => 'Serviço com Preço Negativo',
        'description' => 'Descrição com preço negativo',
        'price' => -10.00, // Preço deve ser positivo
    ];

    $response = $this->actingAs($admin, 'web')
        ->put(route('services.update', $service), $data);

    $response->assertSessionHasErrors('price');
    $response->assertSessionHas('errors', function ($errors) {
        return $errors->has('price') && $errors->first('price') === 'O preço do serviço deve ser um valor positivo.';
    });
});

