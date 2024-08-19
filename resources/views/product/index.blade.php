@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-light mb-4">Produtos</h1>
        
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
                href="#" 
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Adicionar Produto
            </a>
        </div>

        @php
            // simulação
            $content = [
                [24, 'Ração Premium', 'Ração seca para cães adultos', 'PetLove', 'Alimentação', 'R$ 89,90', 50],
                [51, 'Coleira de Couro', 'Coleira de couro ajustável', 'PetSafe', 'Acessórios', 'R$ 39,90', 20],
                [22, 'Brinquedo Bola', 'Bola de borracha resistente', 'Kong', 'Brinquedos', 'R$ 24,90', 100],
                [65, 'Shampoo Pet', 'Shampoo neutro para pets', 'PetClean', 'Higiene', 'R$ 19,90', 75],
                [74, 'Casinha M', 'Casinha de madeira tamanho M', 'PetHouse', 'Abrigos', 'R$ 199,90', 10],
                [34, 'Ração Gatos', 'Ração seca para gatos', 'Whiskas', 'Alimentação', 'R$ 79,90', 60],
                [91, 'Petisqueira', 'Petisqueira em inox', 'Royal Pet', 'Acessórios', 'R$ 49,90', 25],
                [44, 'Tapete Higiênico', 'Tapete higiênico descartável', 'Chalesco', 'Acessórios', 'R$ 89,90', 30],
                [23, 'Arranhador', 'Arranhador para gatos', 'Catnip', 'Brinquedos', 'R$ 59,90', 15],
                [63, 'Roupa Pet', 'Roupa para inverno tamanho P', 'PetFashion', 'Acessórios', 'R$ 89,90', 40],
            ];
        @endphp

        @include('components.table', [
            'header' => ['ID', 'Nome', 'Descrição', 'Marca', 'Categoria', 'Preço', 'Qtd.'],
            'content' => $content,
            'id' => 'productTable',
            'actions' => true
        ])
    </div>
@endsection

