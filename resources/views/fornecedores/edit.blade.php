@extends('layouts.bootstrap')
@section('titulo', 'Editar fornecedor')

@section('content')
<h1 class="h3 mb-3">Editar fornecedor</h1>

<form action="{{ route('fornecedores.update', $fornecedor) }}" method="POST" class="card card-body">
    @csrf
    @method('PUT')
    @include('fornecedores._form')
</form>
@endsection
