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
            'quantity' => $product->quantity,
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

    $response = $this->actingAs($admin, 'web')
        ->patch('/products/'.$product->id, ['name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'toy',
            'price' => 50.00,
            'quantity' => 2, ]);

    $updatedProduct = Product::find($product->id);
    $this->assertEquals('Dog Bed', $updatedProduct->name);
    $this->assertEquals('Wild', $updatedProduct->brand);
    $this->assertEquals('toy', $updatedProduct->category);
    $this->assertEquals('50.00', $updatedProduct->price);
    $this->assertEquals('2', $updatedProduct->quantity);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('products.index'))
        ->assertSessionHas('success', 'Produto atualizado com sucesso.');

});

test('admin cannot update non-existing product info', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->patch('/products/33', ['name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'toy',
            'price' => 50.00,
            'quantity' => 2, ]);
    $response
        ->assertStatus(404);
});

test('admin cannot add a product w/ invalid category', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->post('/products', [
            'name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'nada',
            'price' => 50.00,
            'quantity' => 2,
        ]);

    $response->assertInvalid(['category' => 'The selected category is invalid.']);
});

test('admin cannot add a product w/ invalid price', function () {
    $admin = User::factory()->create();
    $response = $this->actingAs($admin, 'web')
        ->post('/products', [
            'name' => 'Dog Bed',
            'description' => 'Comfortable blue checkered medium sized dog bed.',
            'brand' => 'Wild',
            'category' => 'toy',
            'price' => 7777777.00,
            'quantity' => 2,
        ]);

    $response->assertInvalid(['price' => 'The price field format is invalid.']);
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
    $response = $this->patch('/products/'.$product->id, ['name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
        'price' => 50.00,
        'quantity' => 2, ]);
    $response
        ->assertStatus(302)
        ->assertRedirect(route('login'));
});
