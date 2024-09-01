<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('db:seed', ['--class' => 'PermissionsSeeder']);
    Artisan::call('db:seed', ['--class' => 'RolesSeeder']);
});

test('stock creation', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $product = Product::factory()->create();

    $response = $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/stocks');
});

test('stock creation must have a valid product', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $response = $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => 1,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $response->assertSessionHasErrors('product_id');
});

test('stock creation must have a valid range of quantity', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $product = Product::factory()->create();

    $response1 = $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => -9999999999,
            'justification' => 'Initial stock',
        ]);

    $response2 = $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 9999999999,
            'justification' => 'Initial stock',
        ]);

    $response1->assertSessionHasErrors('quantity');
    $response2->assertSessionHasErrors('quantity');
});

test('stock creation must have a valid justification', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $product = Product::factory()->create();

    $response = $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => fake()->words(1000),
        ]);

    $response->assertSessionHasErrors('justification');
});

test('when a stock record is created, the total stock of the product must be updated', function () {
    $admin = User::factory()->hasEmployee()->create();
    $admin->assignRole('admin');
    $product = Product::factory()->create();

    $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => 10,
            'justification' => 'Initial stock',
        ]);

    $this
        ->actingAs($admin, 'web')
        ->post('/stocks', [
            'product_id' => $product->id,
            'quantity' => -5,
            'justification' => 'Initial stock',
        ]);

    $this->assertEquals(5, $product->refresh()->quantity);
});
