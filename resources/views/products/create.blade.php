@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')

    <div class="p-6" style="padding-left: 250px; padding-right: 250px">

        <h1 class="text-2xl font-normal mb-6">Cadastrar novo Produto</h1>
        
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="Nome"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('name') border-red-500 @enderror" 
                        required
                    >
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <input 
                        type="text" 
                        name="brand" 
                        id="brand" 
                        placeholder="Marca"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('brand') border-red-500 @enderror" 
                        required
                    >
                    @error('brand')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <textarea 
                    name="description" 
                    id="description" 
                    placeholder="Descrição"
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('description') border-red-500 @enderror" 
                    rows="3"
                    maxlength="50"
                ></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <span class="text-sm text-gray-500">0/50</span>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <select 
                        name="category" 
                        id="category" 
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('category') border-red-500 @enderror" 
                        required
                    >
                        <option value="" disabled selected>Categoria</option>
                        <option value="food">Alimentação</option>
                        <option value="toy">Brinquedos</option>
                        <option value="fashion">Acessórios</option>
                        <option value="hygiene">Higiene</option>
                        <option value="health">Saúde</option>
                    </select>
                    @error('category')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <input 
                        type="text" 
                        name="price" 
                        id="price" 
                        placeholder="Valor"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('price') border-red-500 @enderror" 
                        required
                    >
                    @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <input 
                        type="number" 
                        name="quantity" 
                        id="quantity" 
                        placeholder="Quantidade"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('quantity') border-red-500 @enderror" 
                        required
                    >
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('products.index') }}" class="cancel-button">Cancelar</a>
                <button type="submit" class="add-button">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection
