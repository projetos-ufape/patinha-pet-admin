@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
    <style>
        .tab-link {
            padding: 10px 20px;
            border: none;
            border-bottom: 2px solid transparent;
            background-color: transparent;
            font-size: 16px;
            font-weight: bold;
            color: #4A4A4A;
            cursor: pointer;
            transition: border-color 0.3s ease, color 0.3s ease;
        }

        .tab-link.active {
            border-bottom: 2px solid #0056b3;
            color: #0056b3;
        }

        .tab-link:hover {
            color: #0056b3;
        }

        .tab-content {
            padding-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="p-6">
        <h1 class="text-2xl mb-4">Comercial</h1>

        <div class="flex justify-between items-center mb-4 border-b border-gray-200">
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'Atendimentos')">Atendimentos</button>
                <button class="tab-link" onclick="openTab(event, 'Vendas')">Vendas</button>
            </div>
        </div>

        {{-- Conteúdo da aba de Atendimentos --}}
        <div id="Atendimentos" class="tab-content" style="display:block;">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Pesquisar"
                        class="px-4 py-2 border border-gray-100 rounded-lg mr-2" />
                </div> 
                <div class="pagination-container">
                    {{ $appointments->links() }}
                </div>
                <a href="{{ route('appointments.create') }}" class="add-button">
                    <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                    Registrar Atendimento
                </a>
            </div>

            @include('components.table', [
                'header' => [
                    'ID',
                    'Serviço',
                    'Funcionário',
                    'Cliente',
                    'Pet',
                    'Horário Atendimento',
                    'Horário Conclusão',
                    'Status',
                ],
                'content' => $appointments->map(function ($appointment) {
                    $appointmentStatusTranslations = [
                        'pending' => 'Pendente',
                        'completed' => 'Concluído',
                        'canceled' => 'Cancelado',
                    ];

                    $start_time = $appointment->start_time
                        ? \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y H:i')
                        : null;
                    $end_time = $appointment->end_time
                        ? \Carbon\Carbon::parse($appointment->end_time)->format('d/m/Y H:i')
                        : null;

                    return [
                        $appointment->id,
                        $appointment->service->name,
                        $appointment->employee->user->name,
                        $appointment->customer->user->name,
                        $appointment->pet->name,
                        $start_time,
                        $end_time,
                        $appointmentStatusTranslations[$appointment->status] ?? $appointment->status,
                    ];
                }),
                'editRoute' => 'appointments.edit',
                'deleteRoute' => 'appointments.destroy',
            ])
        </div>

        {{-- Conteúdo da aba de Vendas --}}
        <div id="Vendas" class="tab-content" style="display:none;">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <input type="text" id="searchSalesInput" onkeyup="searchSalesTable()" placeholder="Pesquisar"
                        class="px-4 py-2 border border-gray-100 rounded-lg mr-2" />
                </div>
                <div class="pagination-container">
                    {{ $sales->links() }}
                </div>
                <a href="{{ route('sales.create') }}" class="add-button">
                    <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                    Registrar Venda
                </a>
            </div>

            @include('components.table', [
                'header' => [
                    'ID',
                    'Funcionário', 
                    'Produto',                    
                    'Serviço', 
                    'Preço',
                    'Cliente',

                ],
                'content' => $sales->map(function ($sale) {
                    $products = [];
                    $services = [];
                    $totalPrice = 0;

                    foreach ($sale->saleItem as $item) {
                        if ($item->productItem) {
                            $products[] = $item->productItem->product->name ?? 'Produto não especificado';
                        }

                        if ($item->appointmentItem) {
                            $services[] = $item->appointmentItem->appointment->service->name ?? 'Serviço não especificado';
                        }

                        $totalPrice += $item->price ?? 0;
                    }

                    $productNames = implode(', ', $products) ?: 'Nenhum produto';
                    $serviceNames = implode(', ', $services) ?: 'Nenhum serviço';

                    return [
                        $sale->id,
                        $sale->employee->user->name ?? 'N/A',
                        $productNames,
                        $serviceNames,
                        number_format($totalPrice, 2, ',', '.'), 
                        $sale->customer->user->name ?? 'Cliente não especificado',
                    ];
                }),
                'editRoute' => 'sales.edit',
                'deleteRoute' => 'sales.destroy',
            ])
 
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function searchTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toUpperCase();
            var table = document.querySelector("#Atendimentos table");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var tdArray = tr[i].getElementsByTagName("td");
                var found = false;

                for (var j = 0; j < tdArray.length; j++) {
                    if (tdArray[j]) {
                        if (tdArray[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function searchSalesTable() {
            var input = document.getElementById("searchSalesInput");
            var filter = input.value.toUpperCase();
            var table = document.querySelector("#Vendas table");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var tdArray = tr[i].getElementsByTagName("td");
                var found = false;

                for (var j = 0; j < tdArray.length; j++) {
                    if (tdArray[j]) {
                        if (tdArray[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }
    </script>
@endsection
