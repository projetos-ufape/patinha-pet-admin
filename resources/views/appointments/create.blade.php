@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
    <div class="container-custom">
        <h1 class="text-2xl font-normal mb-6">Registrar atendimento</h1>

        <form id="Form" action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="flex mb-6">
                <div style="display: inline-block; width: 49%;">
                    <select name="service_id" id="service"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('service') border-red-500 @enderror"
                        required>
                        <option value="" disabled selected>Serviço</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div style="display: inline-block; width: 49%; margin-left: 2%;">
                    <select name="customer_id" id="customer"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('customer_id') border-red-500 @enderror"
                        required>
                        <option value="" disabled selected>Cliente</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->user->name ?? 'No Name' }}</option>
                        @endforeach

                    </select>
                    @error('customer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <div class="flex mb-6">

                <div style="display: inline-block; width: 49%">
                    <select name="pet_id" id="pet"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('pet') border-red-500 @enderror"
                        required>
                        <option value="" disabled selected>Pet</option>
                        @foreach ($pets as $pets)
                            <option value="{{ $pets->id }}">{{ $pets->name }}</option>
                        @endforeach
                    </select>
                    @error('pet_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div style="display: inline-block; width: 49%; margin-left: 2%;">
                    <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('status') border-red-500 @enderror"
                        required>
                        <option value="" disabled selected>Status</option>
                        <option value="pending">Pendente</option>
                        <option value="completed">Concluído</option>
                        <option value="canceled">Cancelado</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex mb-6">
                <div style="display: inline-block; width: 49%">
                    <input type="datetime-local" name="start_time" id="start_time"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('start_time') border-red-500 @enderror"
                        required>
                    @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: inline-block; width: 49%; margin-left: 2%;">
                    <input type="datetime-local" name="end_time" id="end_time"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="flex justify-between">
                <a href="{{ route('comercial.index') }}" class="cancel-button">Cancelar</a>
                <button type="submit" class="add-button">Registrar</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('client').addEventListener('change', function() {
            var customer_id = this.value;
            var petSelect = document.getElementById('pet');

            petSelect.innerHTML = '<option value="" disabled selected>Carregando...</option>';

            fetch(`/pets/${customer_id}`)
                .then(response => response.json())
                .then(data => {
                    petSelect.innerHTML = '<option value="" disabled selected>Selecione o Pet</option>';
                    data.forEach(function(pet) {
                        var option = document.createElement('option');
                        option.value = pet.id;
                        option.textContent = pet.name;
                        petSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar os pets:', error);
                    petSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar pets</option>';
                });
        });
    </script>
@endsection
