<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Quicksand:wght@100;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased" style="background:#E4EBED">
    <div class="flex flex-col min-h-screen">
        @auth
            @include('layouts.components.navbar')
        @endauth

        <div class="flex flex-1">
            @auth
                @include('layouts.components.sidebar')
            @endauth

            <div class="flex-1 p-6">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
