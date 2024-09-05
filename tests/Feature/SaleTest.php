<?php

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('db:seed', ['--class' => 'PermissionsSeeder']);
    Artisan::call('db:seed', ['--class' => 'RolesSeeder']);
});

test('store sale', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $customer = Customer::factory()->create();
    $product = Product::factory(['quantity' => 5])->create();
    $data = [
        'customer_id' => $customer->id,
        'sale_items' => [
            [
                'price' => 5 * $product->price,
                'type' => 'product',
                'product_item' => [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->post(route('sales.store'), $data);
    $response->assertStatus(302);
    $this->assertDatabaseHas('sales', [
        'employee_id' => $user->employee->id,
        'customer_id' => $customer->id,
    ]);
    $this->assertDatabaseHas('sale_items', [
        'price' => 5 * $product->price,
    ]);
    $this->assertDatabaseHas('product_items', [
        'quantity' => 5,
    ]);
    $this->assertDatabaseHas('products', [
        'quantity' => 0,
    ]);
});

test('store sale with non-existent customer', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $product = Product::factory()->create();
    $data = [
        'customer_id' => 1,
        'sale_items' => [
            [
                'price' => 5 * $product->price,
                'type' => 'product',
                'product_item' => [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->post(route('sales.store'), $data);
    $response->assertStatus(302);
    $response->assertInvalid(['customer_id' => 'O cliente deve existir.']);
});

test('store sale with non-existent product', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $customer = Customer::factory()->create();
    $data = [
        'customer_id' => $customer->id,
        'sale_items' => [
            [
                'price' => 5,
                'type' => 'product',
                'product_item' => [
                    'product_id' => 1,
                    'quantity' => 5,
                ],
            ],
        ],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->post(route('sales.store'), $data);
    $response->assertStatus(302);
    $response->assertInvalid(['sale_items.0.product_item.product_id' => 'O produto de cada item de venda de produto deve existir.']);
});

test('store sale with invalid quantity', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $customer = Customer::factory()->create();
    $product = Product::factory()->create();
    $data = [
        'customer_id' => $customer->id,
        'sale_items' => [
            [
                'price' => 5 * $product->price,
                'type' => 'product',
                'product_item' => [
                    'product_id' => $product->id,
                    'quantity' => 0,
                ],
            ],
        ],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->post(route('sales.store'), $data);
    $response->assertStatus(302);
    $response->assertInvalid(['sale_items.0.product_item.quantity' => 'A quantidade de cada item de venda de produto deve ser 1 ou mais.']);
});

test('store sale with no sale items', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $customer = Customer::factory()->create();
    $data = [
        'customer_id' => $customer->id,
        'sale_items' => [],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->post(route('sales.store'), $data);
    $response->assertStatus(302);
    $response->assertInvalid(['sale_items' => 'Os itens de venda são obrigatórios.']);
});

test('update sale', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $product = Product::factory(['quantity' => 10])->create();
    $sale = Sale::factory()->for($user->employee)->for(Customer::factory())->create();
    $saleItem = SaleItem::factory(['price' => 5 * $product->price, 'sale_id' => $sale->id])->has(ProductItem::factory(['quantity' => 5])->for($product))->create();
    $data = [
        'id' => $sale->id,
        'customer_id' => $sale->customer_id,
        'sale_items' => [
            [
                'id' => $saleItem->id,
                'price' => 10 * $product->price,
                'type' => 'product',
                'product_item' => [
                    'product_id' => $product->id,
                    'quantity' => 10,
                ],
            ],
        ],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->put(route('sales.update', compact('sale')), $data);
    $response->assertStatus(200);
    $this->assertDatabaseHas('sales', [
        'employee_id' => $sale->employee_id,
        'customer_id' => $sale->customer_id,
    ]);
    $this->assertDatabaseHas('sale_items', [
        'price' => 10 * $product->price,
    ]);
    $this->assertDatabaseHas('product_items', [
        'quantity' => 10,
    ]);
    $this->assertDatabaseHas('products', [
        'quantity' => 5,
    ]);
});

test('update sale with no sale items', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $product = Product::factory()->create();
    $sale = Sale::factory()->has(SaleItem::factory()->has(ProductItem::factory(['quantity' => 4])->for($product)))->for($user->employee)->for(Customer::factory())->create();
    $data = [
        'id' => $sale->id,
        'customer_id' => $sale->customer_id,
        'sale_items' => [],
    ];
    $response = $this
        ->actingAs($user, 'web')
        ->put(route('sales.update', compact('sale')), $data);
    $response->assertStatus(302);
    $response->assertInvalid(['sale_items' => 'Devem haver 1 ou mais itens de venda.']);
});

test('destroy sale', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $product = Product::factory(['quantity' => 10])->create();
    $sale = Sale::factory()->has(SaleItem::factory()->has(ProductItem::factory(['quantity' => 5])->for($product)))->for(Employee::factory())->for(Customer::factory())->create();
    $response = $this
        ->actingAs($user, 'web')
        ->delete(route('sales.destroy', compact('sale')));
    $response->assertStatus(200);
    $this->assertDatabaseCount('sales', 0);
    $this->assertDatabaseHas('products', [
        'quantity' => 15,
    ]);
});

test('destroy non-existent sale', function () {
    $user = User::factory()->has(Employee::factory())->create();
    $user->assignRole('admin');
    $response = $this
        ->actingAs($user, 'web')
        ->delete('/sales/10');
    $response->assertStatus(404);
    $this->assertDatabaseCount('sales', 0);
});
