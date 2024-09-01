@extends('layouts.app')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-center bg-[#E4EBED]">
    <h1 id="welcome-message" class="text-2xl font-light text-gray-800 mb-1">Seja bem-vindo(a)</h1>
    <p id="instruction-message" class="text-md mb-2" style="color: #006184;">Para começar, informe seu e-mail</p>

    <form id="login-form" class="w-80" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4 mt-8">
            <div class="flex justify-center">
                <input id="email" style="width: 320px;" class="px-4 py-2 border border-gray-300 rounded-md" type="email" name="email" placeholder="Email" required autofocus autocomplete="username">
            </div>
            @error('email')
                <span class="text-red-500 text-sm mt-2 block text-center">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 relative">
            <div class="flex justify-center">
                <input id="password" style="width: 320px;" class="px-4 py-2 border border-gray-300 rounded-md pr-10" type="password" name="password" placeholder="Senha" required>
                <button type="button" id="toggle-password" class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center">
                    <img src="{{ asset('icons/eye.svg') }}" alt="Show Password" class="h-4 w-4">
                </button>
            </div>
            @error('password')
                <span class="text-red-500 text-sm mt-2 block text-center">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-between items-center mt-4"> 
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar de mim') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center mt-6">
            <button id="login-button" class="bg-red-600 hover:bg-red-700 text-white text-sm font-light py-2 px-5 rounded-lg">
                {{ __('Continuar') }}
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var eyeIcon = document.getElementById('toggle-password').querySelector('img');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.src = '{{ asset("icons/eye-off.svg") }}'; 
            eyeIcon.alt = "Hide Password";
        } else {
            passwordField.type = 'password';
            eyeIcon.src = '{{ asset("icons/eye.svg") }}'; 
            eyeIcon.alt = "Show Password";
        }
    });
</script>
@endsection

<style>
    #toggle-password {
        cursor: pointer; 
    }

    input[type="password"] {
        position: relative; 
    }
</style>
