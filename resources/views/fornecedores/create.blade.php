@extends('layouts.bootstrap')
@section('titulo', 'Novo fornecedor')

@section('content')
<h1 class="h3 mb-3">Novo fornecedor</h1>

<form action="{{ route('fornecedores.store') }}" method="POST" class="card card-body">
    @csrf
    @include('fornecedores._form', ['fornecedor' => null])
</form>
@endsection
