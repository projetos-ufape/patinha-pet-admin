<?php

use App\Models\Product;
use App\Models\User;

test('list of products is displayed', function () {
    $admin = User::factory()->create();
    $products = Product::factory()->count(3)->create();

    $response = $this->actingAs($admin, 'web')
        ->get(route('products.index'));

    foreach ($products as $product) {
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'brand' => $product->brand,
            'category' => $product->category,
            'price' => $product->price,
        ]);
    }
    $response->assertStatus(200);
});

test('list of products is empty when no products have been created', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->get(route('products.index'));

    $this->assertDatabaseCount('products', 0);
});

test('admin can update existing product info', function () {
    $admin = User::factory()->create();
    $product = Product::factory()->create();
    $dataToUpdate = [
        'name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
        'price' => '50.00',
    ];

    $response = $this
        ->actingAs($admin, 'web')
        ->put(route('products.update', compact('product')), $dataToUpdate);

    $this->assertDatabaseHas('products', $dataToUpdate);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('products.index'))
        ->assertSessionHas('success', 'Produto atualizado com sucesso.');
});

test('admin cannot update non-existing product info', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->put('/products/33', [
            'name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'toy',
            'price' => '50.00',
        ]);

    $response
        ->assertStatus(404);
});

test('admin cannot add a product invalid category', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->post('/products', [
            'name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'nada',
            'price' => '50.00',
        ]);

    $response->assertInvalid(['category' => 'The selected category is invalid.']);
});

test('admin cannot add a product invalid price', function () {
    $admin = User::factory()->create();
    $default = [
        'name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
    ];

    $this->actingAs($admin, 'web')
        ->post('/products', [...$default, 'price' => 7777777.00])
        ->assertInvalid(['price']);

    $this->actingAs($admin, 'web')
        ->post('/products', [...$default, 'price' => '7777777fd'])
        ->assertInvalid(['price']);

    $this->actingAs($admin, 'web')
        ->post('/products', [...$default, 'price' => '212.324234'])
        ->assertInvalid(['price']);

    $this->actingAs($admin, 'web')
        ->post('/products', [...$default, 'price' => '-30.40'])
        ->assertInvalid(['price']);
});

test('admin can destroy existing product', function () {
    $admin = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($admin, 'web')
        ->delete('/products/'.$product->id);

    $createdProduct = Product::find($product->id);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('products.index'))
        ->assertSessionHas('success', 'Produto removido com sucesso.');

    $this->assertEquals(null, $createdProduct);
    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

test('admin cannot destroy non-existing product', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->delete('/products/33');
    $response->assertStatus(500);
});

test('non-admin cannot update product list', function () {
    $product = Product::factory()->create();
    $response = $this->put('/products/'.$product->id, [
        'name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
        'price' => '50.00',
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('login'));
});
