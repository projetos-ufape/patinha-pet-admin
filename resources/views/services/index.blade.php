@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">

        <h1 class="text-2xl mb-4">Serviços Prestados</h1>
        
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
                href="{{ route('services.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadastrar Serviço
            </a>


        </div>
        @include('components.table', [
            'header' => ['ID', 'Nome', 'Descrição','Valor'],
            'content' => $services->map(function($service) {
                return [
                    $service->id,
                    $service->name,            
                    $service->description,             
                    $service->price,               
                ];

            }),
            'editRoute' => 'services.edit',
            'deleteRoute' => 'services.destroy',
        ])
        
    </div>

@endsection


