<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Novo Pet</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="">
        <p>Castrar Pet</p>
        
        @if (session()->has('message')) 
          {{session()->get('message')}}
        @endif

        <form action="{{route('pets.store')}}" method="POST">
          @csrf
          <input type="text" name="name" placeholder="Nome" />
          <select name="gender" >
            <option value="female">Fêmea</option>
            <option value="male">Macho</option>
          </select>

          <select name="species">
            <option value="cat">Gato</option>
            <option value="dog">Cachorro</option>
          </select>
          <input type="text" name="race" placeholder="Raça" />
          <input type="number" name="height" placeholder="Altura"/>
          <input type="number" name="weight" placeholder="Peso"/>
          <input type="date" name="birth" placeholder="birth"/>
          <button type="submit">Criar</button>
    </body>
</html>
