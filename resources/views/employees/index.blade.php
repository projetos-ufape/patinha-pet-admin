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

            </div>

            <a
                href="{{ route('employees.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Funcionário
            </a>


        </div>
        @include('components.table', [
            'header' => ['ID', 'Nome', 'CPF','E-mail', 'Endereço'],
            'content' => $employees->map(function($user) {
                return [
                    $user->employee->id ?? 'N/A',
                    $user->name,            
                    $user->cpf,             
                    $user->email,           
                    $user->address['street'] . ', ' . 
                    $user->address['number'] . ' ' . 
                    $user->address['district'] . ' ' .
                    $user->address['city'] . ' - ' . 
                    $user->address['state'],       
                ];
            }),
            'editRoute' => 'employees.edit',
            'deleteRoute' => 'employees.destroy',
        ])
        
    </div>

@endsection


