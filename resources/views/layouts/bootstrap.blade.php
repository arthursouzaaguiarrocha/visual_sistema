<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Sistema') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

@php
    $menu = [
        ['Clientes',        'clientes.index',        'clientes.*'],
        ['Colaboradores',   'colaboradores.index',   'colaboradores.*'],
        ['Fornecedores',    'fornecedores.index',    'fornecedores.*'],
        ['Matérias-primas', 'materias_primas.index', 'materias_primas.*'],
    ];
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                @foreach ($menu as [$texto, $rota, $padrao])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($padrao) ? 'active' : '' }}"
                           href="{{ route($rota) }}">{{ $texto }}</a>
                    </li>
                @endforeach
            </ul>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">Sair</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="container pb-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">Verifique os campos destacados abaixo.</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
