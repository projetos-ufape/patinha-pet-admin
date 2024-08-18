@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')

    <div class="p-6">
        <h1 class="text-2xl mb-4">Clientes</h1>
        
        <div class="flex justify-between items-center mb-4">

        <div class="flex items-center">
                <input
                    type="text"
                    id="searchInput"
                    onkeyup="searchTable()"
                    placeholder="Pesquisar"
                    class="px-4 py-2 border border-gray-100 rounded-lg mr-2"
                />

                <button
                    onclick="filterTable()"
                    class="filter-button"
                >
                    <img src="{{ asset('icons/filter.svg') }}" alt="Filter Icon">
                    Filtrar
                </button>

            </div>

            <a
                href="{{ route('customer.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Cliente
            </a>

        </div>

        @php
            // simulaçao
            $content = [
                [1, 'Maria Oliveira', '987.654.321-00', '(21) 99876-5432', 'maria.oliveira@example.com', 'senha456', 'Rua B, 456'],
                [1, 'Maria Oliveira', '987.654.321-00', '(21) 99876-5432', 'maria.oliveira@example.com', 'senha456', 'Rua B, 456'],                [1, 'Maria Oliveira', '987.654.321-00', '(21) 99876-5432', 'maria.oliveira@example.com', 'senha456', 'Rua B, 456'],
            ];

        @endphp

        @include('components.table', [
            'header' => ['ID', 'Nome', 'CPF', 'Celular', 'E-mail', 'Senha', 'Endereço'],
            'content' => $content,
            'editRoute' => 'customer.edit',
        ])
        
    </div>
@endsection
