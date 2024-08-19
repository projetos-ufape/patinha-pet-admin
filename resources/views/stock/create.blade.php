@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6" style = "padding-left: 250px; padding-right: 250px">
        <h1 class="text-2xl font-light mb-4">Cadastrar Novo Registro</h1>
        
        <form action="{{route('stocks.store')}}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
				<div class="mb-4">
                    <select 
                    name="product_id" 
                    id="product_id" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                    required
                    >
                        <option value="" disabled selected>Produto</option>
						@foreach($products as $product)
                    		<option value="{{ $product->id }}">{{ $product->name }}</option>
                		@endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <input 
                        type="number" 
						step=1
						value=0
						oninput="this.value=Math.round(this.value);"
                        name="quantity" 
                        id="quantity" 
                        placeholder="Quantidade"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                </div>
            </div>

            <div class="mb-4">
                <textarea 
                    name="justification" 
                    id="justification" 
                    placeholder="Justificativa"
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                    rows="3"
                    maxlength="50"
                ></textarea>
                <span class="text-sm text-gray-500">0/50</span>
            </div>

            <div class="flex justify-between">
                <button class="text-teal-600 hover:underline">Cancelar</button>
                <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg" style="background-color: #006184;">Cadastrar</button>
              </div>
        </form>
    </div>
@endsection