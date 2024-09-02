@php 
    $isNotEmpty = !empty($content) && count($content) > 0;
    $withoutActions = isset($withoutActions) && $withoutActions === true;
@endphp

<table id="{{ $tableId ?? 'dataTable' }}" class="min-w-full shadow-lg border rounded-lg overflow-hidden">
    <thead class="text-left text-bold" style="background: var(--Container, #F2F6F7);">
        <tr class="border border-gray-300 {{ $isNotEmpty ? '' : '' }}">
            @foreach ($header as $item)
                <th class="px-6 py-3 font-medium tracking-wider">
                    {{ $item }}
                </th>
            @endforeach
            @if (!$withoutActions)
                <th class="px-6 py-3 font-medium tracking-wider">Ações</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if ($isNotEmpty)
            @foreach ($content as $index => $row)
                <tr class="text-left hover:bg-gray-200 border border-gray-300 @if($index % 2 != 0) bg-gray-100 hover:bg-gray-200 @endif">
                    @foreach ($row as $cell)
                        <td class="px-6 py-4">{{ $cell }}</td>
                    @endforeach
                    @if (!$withoutActions)
                        <td class="px-6 py-4 flex">
                            <a href="{{ route($editRoute, $row[0]) }}" class="text-blue-600 hover:underline">
                                <img src="{{ asset('icons/pencil.svg') }}" alt="Editar" class="h-4 w-4">
                            </a>
                            <form action="{{ route($deleteRoute, $row[0]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-4">
                                    <img src="{{ asset('icons/trash3.svg') }}" alt="Excluir" class="h-4 w-4">
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="{{ count($header) + (!$withoutActions ? 1 : 0) }}" class="text-center text-gray-500">
                    Nenhum resultado encontrado.
                </td>
            </tr>
        @endif
    </tbody>
</table>
