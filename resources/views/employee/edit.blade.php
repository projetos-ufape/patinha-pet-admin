@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Editar Funcionário</h1>
    
    <form action="{{ route('employee.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="nome" id="nome" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Nome" value="{{ old('nome', $employee->nome) }}" required>
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="cpf" id="cpf" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CPF" value="{{ old('cpf', $employee->cpf) }}" required>
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="E-mail" value="{{ old('email', $employee->email) }}" required>
            </div>           
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="text" name="senha" id="senha" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Senha" value="{{ old('senha', $employee->senha) }}" required>
            </div>
        </div>
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <input type="text" name="salario" id="salario" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Salário" value="{{ old('salario', $employee->salario) }}" required>
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <input type="date" name="data_admissao" id="data_admissao" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Data de Admissão" value="{{ old('data_admissao', $employee->data_admissao) }}" required>
            </div>
        </div>

        <hr style="border: 1px solid #BCC9CE; margin: 2rem 0;"> 
    
        <div class="flex mb-6 mt-2">
            <div style="display: inline-block; width: 30%;">
                <input type="text" name="cep" id="cep" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="CEP" value="{{ old('cep', $employee->cep) }}" required>
            </div>
            <div style="display: inline-block; width: 68%; margin-left: 2%;">
                <input type="text" name="endereco" id="endereco" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Endereço" value="{{ old('endereco', $employee->endereco) }}" required>
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <input type="text" name="complemento" id="complemento" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Complemento" value="{{ old('complemento', $employee->complemento) }}">
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="numero" id="numero" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Número" value="{{ old('numero', $employee->numero) }}" required>
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="cidade" id="cidade" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Cidade" value="{{ old('cidade', $employee->cidade) }}" required>
            </div>
            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <input type="text" name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Estado" value="{{ old('estado', $employee->estado) }}" required>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('employee.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Atualizar</button>
        </div>
    </form>
</div>
@endsection
