<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Editar Pet</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="">
        <p>Atualizar {{ $pet->name }}</p>
        
        @if (session()->has('message')) 
          {{session()->get('message')}}
        @endif

        <br/>
        <td>{{ $pet->id }}</td>
        <td>{{ $pet->name }} </td>
        <td>{{ $pet->gender }}</td>
        <td>{{ $pet->species }}</td>
        <td>{{ $pet->race }}</td>
        <td>{{ $pet->height }}</td>
        <td>{{ $pet->weight }}</td>
        <td>{{ $pet->birth }}</td>

        <form action="{{route('pets.update', ['pet' => $pet->id])}}" method="post">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <input type="text" name="name" value="{{$pet->name}}" />
          <!-- <select name="gender" >
            <option value="female">Fêmea</option>
            <option value="male">Macho</option>
          </select>

          <select name="species">
            <option value="cat">Gato</option>
            <option value="dog">Cachorro</option>
          </select>
          <input type="species" name="species" value="{{$pet->species}}" />
          <input type="gender" name="gender" value="{{$pet->gender}}" /> -->
          <input type="text" name="race" value="{{$pet->race}}" />
          <input type="number" name="height" value="{{$pet->height}}" />
          <input type="number" name="weight" value="{{$pet->weight}}" />
          <input type="date" name="birth" value="{{$pet->birth}}" />
          <button type="submit">Atualizar</button>
          
        </form>
    </body>
</html>
