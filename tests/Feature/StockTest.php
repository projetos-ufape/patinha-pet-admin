<?php

use App\Models\Product;

test('stock creation', function () {
    $product = Product::factory()->create();

    $response = $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/stocks');
});

test('stock creation must have a valide product', function () {
    $response = $this
        ->post('/stocks', [
            'product_id' => 1,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $response->assertSessionHasErrors('product_id');
});

test('stock creation must have a valid range of quantity', function () {
    $product = Product::factory()->create();

    $response1 = $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => -9999999999,
            'justification' => 'Initial stock',
        ]);

    $response2 = $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 9999999999,
            'justification' => 'Initial stock',
        ]);

    $response1->assertSessionHasErrors('quantity');
    $response2->assertSessionHasErrors('quantity');
});

test('stock creation must have a valid justification', function () {
    $product = Product::factory()->create();

    $response = $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => fake()->words(1000),
        ]);

    $response->assertSessionHasErrors('justification');
});

test('when a stock record is created, the total stock of the product must be updated', function () {
    $product = Product::factory()->create();

    $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $this
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => -5,
            'justification' => 'Initial stock',
        ]);

    $this->assertEquals(5, $product->refresh()->quantity);
});
