@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-2xl font-normal mb-4">Produtos</h1>
        
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <input
                    type="text"
                    id="searchInput"
                    onkeyup="searchTable()"
                    placeholder="Pesquisar"
                    class="px-4 py-2 border border-gray-100 rounded-lg mr-2"
                />
            </div>

            <a
                href="{{ route('products.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Adicionar Produto
            </a>
        </div>

        @include('components.table', [
            'header' => ['ID', 'Nome', 'Descrição', 'Marca', 'Categoria', 'Preço', 'Qtd.'],
            'content' => $products->map(function($product) {

                $categoryTranslations = [
                    'food' => 'Alimentação',
                    'toy' => 'Brinquedos',
                    'fashion' => 'Acessórios',
                    'hygiene' => 'Higiene',
                    'health' => 'Saúde',
                ];

                return [
                    $product->id, 
                    $product->name,
                    $product->description, 
                    $product->brand, 
                    $categoryTranslations[$product->category] ?? $product->category, 
                    $product->price,
                    $product->quantity, 
                ];
            }),
            'editRoute' => 'products.edit',
            'deleteRoute' => 'products.destroy',
        ])
    </div>

@endsection

