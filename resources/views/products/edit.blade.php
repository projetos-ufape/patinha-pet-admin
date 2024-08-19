@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')

    <div class="p-6" style="padding-left: 250px; padding-right: 250px">

        <h1 class="text-2xl font-normal mb-6">Editar Produto</h1>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="Nome"
                        value="{{ old('name', $product->name) }}"
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
                        value="{{ old('brand', $product->brand) }}"
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
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <span class="text-sm text-gray-500">{{ strlen(old('description', $product->description)) }}/50</span>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <select 
                        name="category" 
                        id="category" 
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full @error('category') border-red-500 @enderror" 
                        required
                    >
                        <option value="" disabled {{ old('category', $product->category) ? '' : 'selected' }}>Categoria</option>
                        <option value="food" {{ old('category', $product->category) == 'food' ? 'selected' : '' }}>Alimentação</option>
                        <option value="toy" {{ old('category', $product->category) == 'toy' ? 'selected' : '' }}>Brinquedos</option>
                        <option value="fashion" {{ old('category', $product->category) == 'fashion' ? 'selected' : '' }}>Acessórios</option>
                        <option value="hygiene" {{ old('category', $product->category) == 'hygiene' ? 'selected' : '' }}>Higiene</option>
                        <option value="health" {{ old('category', $product->category) == 'health' ? 'selected' : '' }}>Saúde</option>
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
                        value="{{ old('price', $product->price) }}"
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
                        value="{{ old('quantity', $product->quantity) }}"
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
                <button type="submit" class="add-button">Salvar Alterações</button>
            </div>
        </form>
    </div>
    
@endsection
