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
        <p>Dados de {{ $pet->name }}</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Gênero</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Altura</th>
                    <th>Peso</th>
                    <th>Data de Nascimento</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>{{ $pet->id }}</td>
                        <td>{{ $pet->name }} </td>
                        <td>{{ $pet->gender }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->race }}</td>
                        <td>{{ $pet->height }}</td>
                        <td>{{ $pet->weight }}</td>
                        <td>{{ $pet->birth }}</td>
                    </tr>
            </tbody>
        </table>


        <form action="{{route('pets.destroy', ['pet' => $pet->id])}}" method="post" >
          @csrf
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit">Deletar</button>
        </form>
    </body>
</html>
