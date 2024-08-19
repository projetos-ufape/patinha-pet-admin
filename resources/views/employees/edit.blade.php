@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Editar Funcionário</h1>
    
    <form action="{{ route('employees.update', $employee->id) }}" method="POST" id="Form">
        @csrf
        @method('PUT')

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Nome" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="cpf" id="cpf" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CPF" value="{{ old('cpf', $user->cpf) }}" required>
                @error('cpf')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="E-mail" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Senha">
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Confirme a Senha">
                @error('password_confirmation')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="salary" id="salary" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Salário" value="{{ old('salary', $employee->salary) }}" required>
                @error('salary')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="date" name="admission_date" id="admission_date" class="w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('admission_date', $employee->admission_date) }}" required>
                @error('admission_date')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr style="border: 1px solid #BCC9CE; margin: 2rem 0;">

        <div class="flex mb-6 mt-2">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="address[cep]" id="cep" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CEP" value="{{ old('address.cep', $user->address['cep']) }}" required>
                @error('address.cep')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address[street]" id="address" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Endereço" value="{{ old('address.street', $user->address['street']) }}" required>
                @error('address.street')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address[district]" id="district" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Bairro" value="{{ old('address.district', $user->address['district']) }}" required>
                @error('address.district')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <input type="text" name="address[complement]" id="complement" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Complemento" value="{{ old('address.complement', $user->address['complement']) }}">
                @error('address.complement')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="address[number]" id="number" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Número" value="{{ old('address.number', $user->address['number']) }}" required>
                @error('address.number')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="address[city]" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Cidade" value="{{ old('address.city', $user->address['city']) }}" required>
                @error('address.city')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <select name="address[state]" id="state" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled>Selecione o Estado</option>
                    @foreach (\App\Enums\AddressState::values() as $state)
                        <option value="{{ $state }}" {{ (old('address.state', $user->address['state']) == $state) ? 'selected' : '' }}>{{ $state }}</option>
                    @endforeach
                </select>
                @error('address.state')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('employees.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Atualizar</button>
        </div>
    </form>
</div>


@endsection
