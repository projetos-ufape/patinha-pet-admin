@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
    <style>
        #modalProdutos,
        #modalServicos {
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            margin-bottom: 16px;
            text-align: center;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .zebra-striping tr:nth-child(odd) {
            background-color: #E0ECED;
        }

        .zebra-striping tr:nth-child(even) {
            background-color: #F0F6F7;
        }
    </style>
@endpush

@section('content')
    <div class="p-6">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="form" action="{{ route("sales.store") }}" method="POST">
            @csrf
            <input hidden name="sale_items" id="sales">

            <h1 class="text-2xl font-light mb-4">Registrar venda</h1>
            <div class="flex space-x-4" style="padding-top: 10px;">
                <select class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" name="customer_id">
                    <option value="" disabled selected hidden>Cliente</option>
                    @foreach ($pendingAppointmentsByCustomer as $customer)
                        <option value="{{ $customer['id'] }}">{{ $customer['name'] }}</option>
                    @endforeach
                </select>
                <select class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none"
                    style="margin-left: 20px; background-color: #ebe8e8;" disabled>
                    <option value="" disabled selected hidden>{{ auth()->user()->name }}</option>
                </select>
            </div>
            <div class="flex justify-between items-center p-4 rounded-lg"
                style="margin-top: 20px; padding-left: 0px; padding-right: 0px;">
                <span class="text-lg font-medium">Lista de produtos</span>
                <a href="#" id="openModalButtonProdutos" class="add-button">
                    <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                    Adicionar Produto
                </a>
            </div>
            <div class="table-container" id="produtosTableContainer">
                @include('components.table', [
                    'tableId' => 'dataTableProdutos',
                    'header' => ['Produto', 'Valor unitário', 'Quantidade', 'Valor'],
                    'content' => [],
                ])
            </div>

            <div class="flex justify-between items-center p-4 rounded-lg"
                style="margin-top: 20px; padding-left: 0px; padding-right: 0px;">
                <span class="text-lg font-medium">Lista de serviços</span>
                <a href="#" id="openModalButtonAtendimentos" class="add-button">
                    <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                    Adicionar Atendimento
                </a>
            </div>
            <div class="table-container" id="atendimentosTableContainer">
                @include('components.table', [
                    'tableId' => 'dataTableAtendimentos',
                    'header' => ['Id','Serviço', 'Data', 'Pet', 'Valor'],
                    'content' => [],
                ])
            </div>
            <div class="flex justify-between">
                <a href="{{ route('employees.index') }}" class="cancel-button">Cancelar</a>
                <button id="btnForm" type="submit" for="form" class="add-button" style="border-radius: 20px;">Registrar</button>
            </div>
        </form>
    </div>

    <!-- Modal produtos -->
    <div id="modalProdutos" class="fixed inset-0 z-10 hidden overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity"
        aria-labelledby="modal-title" aria-modal="true" data-backdrop="static">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="text-center" style="margin-top: 10px;">
                        <h3 class="text-lg font-light leading-6 text-gray-900" id="modal-title">Adicionar Produto</h3>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center space-x-4">
                            <select id="select-produtos"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                <option value="" disabled selected hidden>Selecione um produto</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            <input id="quantidade-produtos" type="number"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none"
                                style="margin-left: 10px; max-width: 20%;" placeholder="Qtde" min="0">
                        </div>
                    </div>
                </div>
                <div class="flex justify-between"
                    style="padding-left: 20px; padding-right: 20px; padding-top: 12px; padding-bottom: 12px;">
                    <a href="#" id="cancelButtonProdutos" class="cancel-button" style="color: gray;">Cancelar</a>
                    <button type="" id="adicionarProduto" class="add-button"
                        style="border-radius: 20px;">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal serviços -->
    <div id="modalServicos" class="fixed inset-0 z-10 hidden overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity"
        aria-labelledby="modal-title" aria-modal="true" data-backdrop="static">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0"
            style="min-width: 450px;">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="text-center" style="margin-top: 10px;">
                        <h3 class="text-lg font-light leading-6 text-gray-900" id="modal-title-atendimento">Adicionar
                            Atendimento</h3>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center space-x-4">
                            <select id="select-atendimento"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                <option value="" disabled selected hidden>Selecione um atendimento</option>
                                @foreach ($pendingAppointmentsByCustomer as $pending)
                                    @foreach ($pending['appointments'] as $appointment)
                                        <option value="{{ $appointment['id'] }}" 
                                            id="{{ $appointment['id'] }}" 
                                            data-service-name="{{ $appointment['service_name'] }}" 
                                            data-date="{{ $appointment['date'] }}" 
                                            data-pet-name="{{ $appointment['pet_name'] }}" 
                                            data-value="{{ $appointment['value'] }}">
                                            {{ $appointment['service_name'] }} - {{ $appointment['pet_name'] }} - {{ $appointment['date'] }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between"
                    style="padding-left: 20px; padding-right: 20px; padding-top: 12px; padding-bottom: 12px;">
                    <a href="#" id="cancelButtonAtendimentos" class="cancel-button" style="color: gray;">Cancelar</a>
                    <button type="" id="adicionarAtendimento" class="add-button"
                        style="border-radius: 20px;">Adicionar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const pendingAppointmentsByCustomer = @json($pendingAppointmentsByCustomer);
        const products = @json($products);

        document.addEventListener('DOMContentLoaded', function() {
            const openModalButtonProdutos = document.getElementById('openModalButtonProdutos');
            const openModalButtonAtendimentos = document.getElementById('openModalButtonAtendimentos');
            const modal = document.getElementById('modalProdutos');
            const modalServicos = document.getElementById('modalServicos');
            const cancelButtonProdutos = document.getElementById('cancelButtonProdutos');
            const cancelButtonAtendimentos = document.getElementById('cancelButtonAtendimentos');
            const adicionarProduto = document.getElementById('adicionarProduto');
            const produtoSelect = document.getElementById('select-produtos');
            const quantidadeInput = document.getElementById('quantidade-produtos');
            const adicionarAtendimento = document.getElementById('adicionarAtendimento');
            const atendimentoSelect = document.getElementById('select-atendimento');
            let linhaParaEditar = null;

            atualizarVisibilidadeTabela('dataTableProdutos');
            atualizarVisibilidadeTabela('dataTableAtendimentos');

            function atualizarVisibilidadeTabela(tableId) {
                const tabela = document.getElementById(tableId);
                const tabelaCorpo = tabela.querySelector('tbody');
                const header = tabela.querySelector('thead');
                const message = document.getElementById('title-sem-registro');

                if (tabelaCorpo.children.length === 0) {
                    header.style.display = 'none';
                    message.classList.remove('hidden');
                } else {
                    header.style.display = '';
                    message.classList.add('hidden');
                }
            }

            function addRowToTable(tableId, rowData, dados) {
                const tabela = document.getElementById(tableId);
                const tabelaCorpo = tabela.querySelector('tbody');
                const novaLinha = document.createElement('tr');

                rowData.forEach(cellData => {
                    const cell = document.createElement('td');
                    cell.className = 'px-6 py-4';
                    cell.textContent = cellData;
                    novaLinha.appendChild(cell);
                });

                const colunaAcoes = document.createElement('td');
                colunaAcoes.className = 'px-6 py-4 flex';
                colunaAcoes.innerHTML = `
            <a href="#" class="text-blue-600 hover:underline editar">
                <img src="{{ asset('icons/pencil.svg') }}" alt="Editar" tipo-modal='${tableId}' id="editarTable" dados='${dados}' class="h-4 w-4">
            </a>
                    <button class="text-red-600 hover:underline ml-4 excluir">
                        <img src="{{ asset('icons/trash3.svg') }}" alt="Excluir" class="h-4 w-4">
                    </button>
                `;
                novaLinha.appendChild(colunaAcoes);
                tabelaCorpo.appendChild(novaLinha);
                tabela.classList.add('zebra-striping');

                atualizarVisibilidadeTabela(tableId);
            }

            if (openModalButtonProdutos && modal) {
                openModalButtonProdutos.addEventListener('click', function(event) {
                    event.preventDefault();
                    modal.style.display = 'flex';
                });
            }

            if (cancelButtonProdutos && modal) {
                cancelButtonProdutos.addEventListener('click', function(event) {
                    event.preventDefault();
                    modal.style.display = 'none';
                    resetarFormularioModal('produto');
                });
            }

            if (openModalButtonAtendimentos && modalServicos) {
                openModalButtonAtendimentos.addEventListener('click', function(event) {
                    event.preventDefault();
                    modalServicos.style.display = 'flex';
                });
            }

            if (cancelButtonAtendimentos && modalServicos) {
                cancelButtonAtendimentos.addEventListener('click', function(event) {
                    event.preventDefault();
                    modalServicos.style.display = 'none';
                    resetarFormularioModal('atendimento');
                });
            }

            if (adicionarProduto) {
                adicionarProduto.addEventListener('click', function(event) {
                    event.preventDefault();
                    const produtoId = produtoSelect.value;
                    const quantidade = quantidadeInput.value;

                    if (!produtoId || !quantidade || quantidade <= 0) {
                        alert('Por favor, selecione um produto e insira uma quantidade válida.');
                        return;
                    }
                    const dadosProdutos = @json($products);
                    const valorUnitario = dadosProdutos.find(produto => produto.id === Number(produtoId))
                        .price;
                    const productName = produtoSelect.options[produtoSelect.selectedIndex].text;
                    const valor = Number(valorUnitario) * Number(quantidade);

                    if (linhaParaEditar) {
                        linhaParaEditar.children[0].textContent = productName;
                        linhaParaEditar.children[1].textContent = valorUnitario;
                        linhaParaEditar.children[2].textContent = quantidade;
                        linhaParaEditar.children[3].textContent = valor;
                        linhaParaEditar = null;
                    } else {
                        const dados = {
                            idProduto: produtoId,
                            quantidade: quantidade,
                        }
                        addRowToTable('dataTableProdutos', [productName, valorUnitario, quantidade, valor],
                            JSON.stringify(dados));
                    }
                    resetarFormularioModal('produto');
                    modal.style.display = 'none';
                });
            }

            if (adicionarAtendimento) {
    adicionarAtendimento.addEventListener('click', function(event) {
        event.preventDefault();
        const atendimentoId = atendimentoSelect.value;

        if (!atendimentoId) {
            alert('Por favor, selecione um atendimento.');
            return;
        }

        // Pega o atendimento selecionado
        const selectedOption = atendimentoSelect.options[atendimentoSelect.selectedIndex];
        const id = selectedOption.getAttribute('id');
        const serviceName = selectedOption.getAttribute('data-service-name');
        const date = selectedOption.getAttribute('data-date');
        const petName = selectedOption.getAttribute('data-pet-name');
        const value = selectedOption.getAttribute('data-value');

        if (linhaParaEditar) {

            linhaParaEditar.children[0].textContent = atendimentoId;
            linhaParaEditar.children[1].textContent = serviceName;
            linhaParaEditar.children[2].textContent = date;
            linhaParaEditar.children[3].textContent = petName;
            linhaParaEditar.children[4].textContent = value;
            linhaParaEditar = null;
        } else {
            // Se estiver adicionando um novo atendimento, cria uma nova linha na tabela
            const dados = {
                idAtendimento: atendimentoId
            };
            addRowToTable('dataTableAtendimentos', [id, serviceName, date, petName, value], dados);
        }
        resetarFormularioModal('atendimento');
        modalServicos.style.display = 'none';
    });
}

            document.addEventListener('click', function(event) {
                if (event.target.closest('.excluir')) {
                    const confirmacao = confirm('Tem certeza que deseja excluir este item?');
                    if (confirmacao) {
                        const linha = event.target.closest('tr');
                        linha.remove();
                        atualizarVisibilidadeTabela('dataTableProdutos');
                    }
                }

                if (event.target.closest('.editar')) {
                    event.preventDefault();
                    linhaParaEditar = event.target.closest('tr');
                    const buttonEditar = document.getElementById('editarTable');
                    const tipoModal = buttonEditar.getAttribute('tipo-modal');

                    if (tipoModal === 'dataTableProdutos') {
                        const dados = JSON.parse(buttonEditar.getAttribute('dados'));
                        const produtoId = dados.idProduto;
                        const quantidade = dados.quantidade;

                        produtoSelect.value = produtoId;
                        quantidadeInput.value = quantidade;
                        adicionarProduto.textContent = 'Editar';
                        modal.style.display = 'flex';
                    }

                    if (tipoModal === 'dataTableAtendimentos') {
                        const dados = JSON.parse(buttonEditar.getAttribute('dados'));
                        const atendimentoId = dados.idAtendimento;

                        atendimentoSelect.value = atendimentoId;
                        adicionarAtendimento.textContent = 'Editar';
                        modalServicos.style.display = 'flex';
                    }
                }
            });

            function resetarFormularioModal(modal) {
                if (modal === 'produto') {
                    produtoSelect.value = '';
                    quantidadeInput.value = '';
                    adicionarProduto.textContent = 'Adicionar';
                    linhaParaEditar = null;
                }

                if (modal === 'atendimento') {
                    atendimentoSelect.value = '';
                    adicionarAtendimento.textContent = 'Adicionar';
                    linhaParaEditar = null;
                }
            }

            const form = document.querySelector('form');
            const formBtn = document.getElementById('btnForm');
            const saleItemsInput = document.getElementById('sales');
            const productsTable = document.getElementById('dataTableProdutos');
            const servicesTable = document.getElementById('dataTableAtendimentos');

            formBtn.addEventListener('click', function(event) {
                event.preventDefault();

                const produtos = [];
                const produtosRows = productsTable.querySelectorAll('tbody tr');
                produtosRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const product = {
                        type: 'product',
                        price: parseFloat(cells[1].textContent), // Preço unitário
                        product_item: {
                            product_id: products.find(p => cells[0].textContent == p.name && cells[1].textContent == p.price)?.id, // TODO: melhorar obter Id do produto
                            quantity: parseInt(cells[2].textContent), // Quantidade
                        }
                    };
                    produtos.push(product);
                });

                const atendimentos = [];
                const atendimentosRows = servicesTable.querySelectorAll('tbody tr');
                atendimentosRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const service = {
                        type: 'appointment',
                        price: parseFloat(cells[4].textContent),
                        appointment_item: {
                            appointment_id: parseInt(cells[0].textContent), 
                        }
                    };
                    atendimentos.push(service);
                });

                const saleItems = [...produtos, ...atendimentos];

                if (saleItems.length === 0) {
                    alert('Por favor, adicione ao menos um produto ou atendimento.');
                    return;
                }

                saleItemsInput.value = JSON.stringify(saleItems);
                event.target.closest('form').submit();
            });
        });
    </script>
@endsection