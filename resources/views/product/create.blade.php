@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6" style = "padding-left: 250px; padding-right: 250px">
        <h1 class="text-2xl font-light mb-4">Adicionar novo produto</h1>
        
        <form action="#" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        placeholder="Nome"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                </div>

                <div class="mb-4">
                    <input 
                        type="text" 
                        name="marca" 
                        id="marca" 
                        placeholder="Marca"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                </div>
            </div>

            <div class="mb-4">
                <textarea 
                    name="descricao" 
                    id="descricao" 
                    placeholder="Descrição"
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                    rows="3"
                    maxlength="50"
                ></textarea>
                <span class="text-sm text-gray-500">0/50</span>
            </div>



            <div class="grid grid-cols-3 gap-4" style = "grid-template-columns: repeat(3, minmax(0, 1fr))">
                <div class="mb-4">
                    <select 
                        name="categoria" 
                        id="categoria" 
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                        <option value="" disabled selected>Categoria</option>
                        <option value="alimentacao">Alimentação</option>
                        <option value="brinquedos">Brinquedos</option>
                        <option value="acessorios">Acessórios</option>
                        <option value="higiene">Higiene</option>
                        <option value="abrigos">Abrigos</option>
                    </select>
                </div>

                <div class="mb-4">
                    <input 
                        type="text" 
                        name="preco" 
                        id="preco" 
                        placeholder="Preço"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                </div>

                <div class="mb-4">
                    <input 
                        type="number" 
                        name="quantidade" 
                        id="quantidade" 
                        placeholder="Qtd."
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-lg w-full" 
                        required
                    >
                </div>
            </div>

            <div class="flex justify-between">
                <button class="text-teal-600 hover:underline">Cancelar</button>
                <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg" style="background-color: #006184;">Cadastrar</button>
              </div>
        </form>
    </div>
@endsection
