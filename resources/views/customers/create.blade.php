@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Cadastrar novo Cliente</h1>

    <form id="Form" action="{{ route('customers.store') }}" method="POST">
        @csrf
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Nome" required>
            </div>    
            <div style="display: inline-block; width: 40%; margin-left: 2%;">
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="E-mail" required>
            </div>
            <div style="display: inline-block; width: 30%; margin-left: 2%;">
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Senha" required>
            </div>
        </div>
        
        <div class="flex mb-6">
        
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Celular" required>
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="cpf" id="cpf" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CPF" required>
            </div>
        </div>

        <hr style="border: 1px solid #BCC9CE; margin: 2rem 0;"> 
    
        <div class="flex mb-6 mt-2">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="zip_code" id="zip_code" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CEP" required>
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="address" id="address" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Endereço" required>
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <input type="text" name="complement" id="complement" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Complemento">
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="number" id="number" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Número" required>
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="city" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Cidade" required>
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="state" id="state" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Estado" required>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('customers.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Cadastrar</button>
        </div>
    </form>
</div>

<script>


</script>


@endsection

