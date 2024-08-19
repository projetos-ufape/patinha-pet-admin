@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Editar Cliente</h1>

    <form id="editCustomerForm" action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" placeholder="Nome" value="{{ $user->name }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>    
            <div style="display: inline-block; width: 40%; margin-left: 2%;">
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" placeholder="E-mail" value="{{ $user->email }}" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 30%; margin-left: 2%;">
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror" placeholder="Senha">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('phone_number') border-red-500 @enderror" placeholder="Celular" value="{{ $customer->phone_number }}" required>
                @error('phone_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="cpf" id="cpf" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('cpf') border-red-500 @enderror" placeholder="CPF" value="{{ $user->cpf }}" required>
                @error('cpf')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <hr style="border: 1px solid #BCC9CE; margin: 2rem 0;"> 
    
        <div class="flex mb-6 mt-2">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="zip_code" id="zip_code" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('zip_code') border-red-500 @enderror" placeholder="CEP" value="{{ $user->zip_code }}" required>
                @error('zip_code')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address" id="address" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('address') border-red-500 @enderror" placeholder="Endereço" value="{{ $user->address }}" required>
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <input type="text" name="complement" id="complement" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Complemento" value="{{ $user->complement }}">
                @error('complement')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="number" id="number" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('number') border-red-500 @enderror" placeholder="Número" value="{{ $user->number }}" required>
                @error('number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="city" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('city') border-red-500 @enderror" placeholder="Cidade" value="{{ $user->city}}" required>
                @error('city')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <select name="address[state]" id="state" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Selecione o Estado</option>
                    @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
                @error('address.state')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('customers.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Atualizar</button>
        </div>
    </form>
</div>

@endsection
