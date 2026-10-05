@props(['ativo'])

<span class="badge text-bg-{{ $ativo ? 'success' : 'secondary' }}">{{ $ativo ? 'Ativo' : 'Inativo' }}</span>
