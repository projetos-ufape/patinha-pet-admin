@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Cadastrar novo Funcionário</h1>
    
    <form id="employeeForm" action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Nome" required>
                @error('name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="cpf" id="cpf" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CPF" required>
                @error('cpf')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
                
        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="E-mail" required>
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Senha" required>
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Confirme a Senha" required>
                @error('password_confirmation')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="salary" id="salary" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Salário" required>
                @error('salary')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="date" name="admission_date" id="admission_date" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                @error('admission_date')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr style="border: 1px solid #BCC9CE; margin: 2rem 0;"> 
    
        <div class="flex mb-6 mt-2">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="address[cep]" id="zip_code" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CEP" required>
                @error('address.cep')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address[street]" id="address" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Endereço" required>
                @error('address.street')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address[district]" id="district" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Bairro" required>
                @error('address.district')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <input type="text" name="address[complement]" id="complement" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Complemento">
                @error('address.complement')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="address[number]" id="number" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Número" required>
                @error('address.number')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="address[city]" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Cidade" required>
                @error('address.city')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <select name="address[state]" id="state" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Selecione o Estado</option>
                    @foreach (\App\Enums\AddressState::values() as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
                @error('address.state')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('employees.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Cadastrar</button>
        </div>
    </form>
</div>

<script>

</script>

@endsection
