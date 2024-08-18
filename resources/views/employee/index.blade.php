@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <h1 class="text-2xl mb-4">Funcionário</h1>
        
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
                href="{{ route('employee.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Funcionário
            </a>


        </div>

        @php
            $content = [
                [1, 'Maria Oliveira', '987.654.321-00','500','(21) 99876-5432', 'maria.oliveira@example.com', 'senha456', 'Rua B, 456'],
                [1, 'Maria Oliveira', '987.654.321-00', '700','(21) 99876-5432', 'maria.oliveira@example.com', 'senha456', 'Rua B, 456'],            
            ];

        @endphp


        @include('components.table', [
            'header' => ['ID', 'Nome', 'CPF', 'Salario', 'Celular',  'E-mail', 'Senha', 'Endereço'],
            'content' => $content,
            'editRoute' => 'employee.edit',
        ])
        
    </div>
@endsection
