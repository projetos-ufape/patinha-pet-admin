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
        <h1 class="text-2xl font-light mb-4">Registrar venda</h1>
        <form method="POST" action="{{ route('sales.store') }}">
            @csrf
            <div class="flex space-x-4" style="padding-top: 10px;">
                <select id="select-clientes" name="customer_id" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
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
                    'header' => ['Serviço', 'Data', 'Pet', 'Valor'],
                    'content' => [],
                ])
            </div>
            <input type="hidden" name="sale_items" id="saleItems">
            <div class="flex justify-between">
                <a href="{{ route('employees.index') }}" class="cancel-button">Cancelar</a>
                <button type="submit" class="add-button" style="border-radius: 20px;">Registrar</button>
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
                        </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between"
                    style="padding-left: 20px; padding-right: 20px; padding-top: 12px; padding-bottom: 12px;">
                    <a href="#" id="cancelButtonAtendimentos" class="cancel-button" style="color: gray;">Cancelar</a>
                    <button type="submit" id="adicionarAtendimento" class="add-button"
                        style="border-radius: 20px;">Adicionar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <script>
        
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
    const customerSelect = document.getElementById('select-clientes');
    const form = document.querySelector('form');
    const saleItemsInput = document.getElementById('saleItems');
    const productsTable = document.getElementById('dataTableProdutos');
    const servicesTable = document.getElementById('dataTableAtendimentos');
    let linhaParaEditar = null;

    atualizarVisibilidadeTabela('dataTableProdutos');
    atualizarVisibilidadeTabela('dataTableAtendimentos');

    const pendingAppointmentsByCustomer = @json($pendingAppointmentsByCustomer);

    // Função para atualizar a visibilidade da tabela e do cabeçalho
    function atualizarVisibilidadeTabela(tableId) {
        const tabela = document.getElementById(tableId);
        const tabelaCorpo = tabela.querySelector('tbody');
        const header = tabela.querySelector('thead');
        const message = document.getElementById('title-sem-registro');

        if (tabelaCorpo.children.length === 0) {
            header.style.display = 'none';
            if (message) message.classList.remove('hidden');
        } else {
            header.style.display = '';
            if (message) message.classList.add('hidden');
        }
    }

    function resetarTabelaServicos() {
        const tabelaServicos = document.getElementById('dataTableAtendimentos').querySelector('tbody');
        tabelaServicos.innerHTML = '';
        atualizarVisibilidadeTabela('dataTableAtendimentos');
    }

    // Função para adicionar linha na tabela
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

    // Eventos para abrir e fechar modais de produtos
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

    // Eventos para abrir e fechar modais de atendimentos
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

    // Adicionar Produto à Tabela
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
            const valorUnitario = dadosProdutos.find(produto => produto.id === Number(produtoId)).price;
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
                addRowToTable('dataTableProdutos', [productName, valorUnitario, quantidade, valor], JSON.stringify(dados));
            }
            resetarFormularioModal('produto');
            modal.style.display = 'none';
        });
    }

    // Adicionar Atendimento à Tabela
    if (adicionarAtendimento) {
        adicionarAtendimento.addEventListener('click', function(event) {
            event.preventDefault();
            const atendimentoId = atendimentoSelect.value;

            if (!atendimentoId) {
                alert('Por favor, selecione um atendimento.');
                return;
            }

            const selectedOption = atendimentoSelect.options[atendimentoSelect.selectedIndex];
            const serviceName = selectedOption.getAttribute('data-service-name') || 'N/A';
            const date = selectedOption.getAttribute('data-date') || 'N/A';
            const petName = selectedOption.getAttribute('data-pet-name') || 'N/A';
            const value = selectedOption.getAttribute('data-value') || 'N/A';

            if (linhaParaEditar) {
                linhaParaEditar.children[0].textContent = serviceName;
                linhaParaEditar.children[1].textContent = date;
                linhaParaEditar.children[2].textContent = petName;
                linhaParaEditar.children[3].textContent = value;
                linhaParaEditar = null;
            } else {
                const dados = {
                    idAtendimento: atendimentoId,
                    serviceName: serviceName,
                    date: date,
                    petName: petName,
                    value: value
                };
                addRowToTable('dataTableAtendimentos', [serviceName, date, petName, value], JSON.stringify(dados));
            }

            resetarFormularioModal('atendimento');
            modalServicos.style.display = 'none';
        });
    }

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
            const buttonEditar = event.target.closest('#editarTable');
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

    customerSelect.addEventListener('change', function() {
        resetarTabelaServicos();
        const selectedCustomerId = this.value;
        atendimentoSelect.innerHTML = '<option value="" disabled selected hidden>Selecione um atendimento</option>';

        const selectedCustomer = pendingAppointmentsByCustomer.find(customer => customer.id == selectedCustomerId);

        if (selectedCustomer) {
            selectedCustomer.appointments.forEach(appointment => {
                const option = document.createElement('option');
                option.value = appointment.id;
                option.textContent = `Atendimento ${appointment.id} - Serviço ${appointment.service_name}`;
                option.setAttribute('data-service-name', appointment.service_name);
                option.setAttribute('data-date', appointment.date);
                option.setAttribute('data-pet-name', appointment.pet_name);
                option.setAttribute('data-value', appointment.value);
                atendimentoSelect.appendChild(option);
            });
        }
    });


    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir o envio padrão do formulário

        // Capturar os dados de produtos
        const produtos = [];
        const produtosRows = productsTable.querySelectorAll('tbody tr');
        produtosRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const product = {
                type: 'product',
                product_item: {
                    product_id: cells[0].getAttribute('data-product-id'), // Id do produto
                    quantity: parseInt(cells[2].textContent, 10), // Quantidade
                    price: parseFloat(cells[1].textContent) // Preço unitário
                }
            };
            produtos.push(product);
        });

        // Capturar os dados de atendimentos
        const atendimentos = [];
        const atendimentosRows = servicesTable.querySelectorAll('tbody tr');
        atendimentosRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const service = {
                type: 'appointment',
                appointment_item: {
                    appointment_id: cells[0].getAttribute('data-appointment-id'), // Id do atendimento
                    price: parseFloat(cells[3].textContent) // Preço do atendimento
                }
            };
            atendimentos.push(service);
        });

        // Montar o array sale_items
        const saleItems = [...produtos, ...atendimentos];

        // Verificar se existem itens de venda
        if (saleItems.length === 0) {
            alert('Por favor, adicione ao menos um produto ou atendimento.');
            return;
        }

        // Atualizar o campo hidden com os dados de sale_items
        saleItemsInput.value = JSON.stringify(saleItems);

        // Enviar o formulário com os dados
        form.submit();
    });
});


</script>

@endsection
