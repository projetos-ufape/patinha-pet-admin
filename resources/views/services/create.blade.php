@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Cadastrar novo Serviço</h1>

    <form id="Form" action="{{ route('services.store') }}" method="POST">
        @csrf

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" placeholder="Nome do Serviço" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('price') border-red-500 @enderror" placeholder="Valor" required>
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('description') border-red-500 @enderror" placeholder="Descrição do Serviço" rows="5" required></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('services.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Cadastrar</button>
        </div>
    </form>
</div>
@endsection
