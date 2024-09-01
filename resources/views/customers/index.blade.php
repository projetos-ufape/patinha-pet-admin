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

            </div>

            <a
                href="{{ route('customers.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Cliente
            </a>

        </div>

        @include('components.customer-table', [
            'header' => ['ID', 'Nome', 'CPF', 'Celular', 'E-mail'],
            'content' => $customers->map(function($user) {

            $formattedPhone = preg_replace('/(\d{2})(\d{5})(\d)/', '($1) $2-$3', $user->customer->phone_number);
            $formattedCpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf);
                
                return [
                    $user->customer->id, 
                    $user->name,
                    $formattedCpf,
                    $formattedPhone, 
                    $user->email, 
                ];
            }),
            'editRoute' => 'customers.edit',
            'deleteRoute' => 'customers.destroy',
            'historyRoute' => 'customers.history',
        ])
    </div>


@endsection

