@props(['editar', 'excluir', 'confirmar' => 'Deseja realmente excluir este registro?'])

<td class="text-end text-nowrap">
    <a href="{{ $editar }}" class="btn btn-sm btn-outline-primary">Editar</a>
    <form action="{{ $excluir }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $confirmar }}')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
    </form>
</td>
