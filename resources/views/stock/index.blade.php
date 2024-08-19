@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')

    <div class="p-6">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl mb-4">Estoque</h1>
        
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
                href="{{ route('stocks.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Novo Registro
            </a>

        </div>

        @include('components.simple-table', [
            'header' => ['ID', 'Produto', 'Usuário', 'Quantidade', 'Justificativa', 'Cadastro'],
            'content' => $stocks->map(function($stock) {
                return [
                    $stock->id,
                    $stock->product->name,
					$stock->user->name,
                    $stock->quantity,
					$stock->justification,
                    $stock->created_at,
                ];
            })
        ])

    </div>

@endsection