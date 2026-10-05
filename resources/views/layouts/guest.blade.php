<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-100 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <a href="/" class="mb-8 flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-lg font-bold text-white shadow-lg shadow-indigo-600/30">
                {{ strtoupper(substr(config('app.name', 'S'), 0, 1)) }}
            </div>
            <span class="text-xl font-semibold text-slate-800">{{ config('app.name', 'Sistema') }}</span>
        </a>
        <div class="w-full max-w-md rounded-2xl border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
