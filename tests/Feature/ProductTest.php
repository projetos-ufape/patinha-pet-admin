<?php

use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson as FluentAssertableJson;

test('list of products is displayed', function (){
    $product = Product::factory()->create(); 

    $response = $this->get('/products');
    $response->assertOk(); 
    $response->assertJson(fn (FluentAssertableJson $json) => 
    $json->has('data') 
        ->where('data.0.id', $product->id) 
        ->etc()
);
});

test('list of products is empty when no products have been created', function () {
    $response = $this->get('/products');
    $response->assertOk();
    $response->assertJson([
        'data' => []
    ]);
});

test('product info was successfully updated', function () {
    $product = Product::factory()->create(); 

    $response = $this->patch('/product/'.$product->id, ['name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
        'price' => 50.00,
        'quantity' => 2,]);
    
    $updatedProduct = Product::find($product->id);
    $this->assertEquals('Dog Bed', $updatedProduct->name);
    $this->assertEquals('Wild', $updatedProduct->brand);
   
    $response->assertStatus(200);
    $response->assertJson([
        'name' => 'Dog Bed',
        'brand' => 'Wild'
        ]);

    //$response->assertRedirect('/products');
});


test('show specific product information successfully', function () {
	$product = Product::factory()->create();

    $response = $this->get('/product/'.$product->id);

	$response->assertStatus(200);
	$response->assertJson([
		'id' => $product->id,
	]);
});

test('adding a product w/ invalid category', function () {

    $response = $this->post('/products', [
        'name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'nada',
        'price' => 50.00,
        'quantity' => 2,
    ]);

    $response->assertInvalid(['category' => 'The selected category is invalid.']);
});

test('adding a product w/ invalid price', function () {

    $response = $this->post('/products', [
        'name' => 'Dog Bed',
        'description' => 'Comfortable blue checkered medium sized dog bed.',
        'brand' => 'Wild',
        'category' => 'toy',
        'price' => 7777777.00,
        'quantity' => 2,
    ]);

    $response->assertInvalid(['price' => 'The price field format is invalid.']);
});

test('destroy existing product', function () {
	$product = Product::factory()->create();

    $response = $this->delete('/product/'.$product->id);

	$createdProduct = Product::find($product->id);

	$response->assertStatus(200);
	$response->assertJson([
		'id' => $product->id,
	]);
	$this->assertEquals(null, $createdProduct);
});

test('destroy non-existing product', function () {
    $response = $this->delete('/product/33');
    $response->assertStatus(500);
});
