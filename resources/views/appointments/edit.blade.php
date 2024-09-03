@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">
    <h1 class="text-2xl font-normal mb-6">Editar atendimento</h1>

    <form id="Form" action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <select name="service_id" id="service" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('service') border-red-500 @enderror" required>
                    <option value="" disabled>Serviço</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <select name="customer_id" id="customer" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('customer') border-red-500 @enderror" required>
                    <option value="" disabled>Cliente</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $appointment->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%">
                <select name="pet_id" id="pet" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('pet') border-red-500 @enderror" required>
                    <option value="" disabled>Pet</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}" {{ $appointment->pet_id == $pet->id ? 'selected' : '' }}>
                            {{ $pet->name }}
                        </option>
                    @endforeach
                </select>
                @error('pet_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('status') border-red-500 @enderror" required>
                    <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                    <option value="canceled" {{ $appointment->status == 'canceled' ? 'selected' : '' }}>Cancelado</option>
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
                       value="{{$appointment->start}}" required>
                @error('start_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="datetime-local" name="end_time" id="end_time"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md @error('end_time') border-red-500 @enderror"
                       value="{{ old('end_time', $end_time ?? '') }}">
                @error('end_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>            

        <div class="flex justify-between">
            <a href="{{ route('comercial.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Salvar alterações</button>
        </div>
    </form>
</div>
@endsection
    