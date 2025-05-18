<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Aplicativo moderno construído com Laravel">

    <title>@yield('title', 'Meu App')</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- SortableJS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    {{-- Ícones Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
{{-- Navbar (ajuste o componente se necessário) --}}
@include('components.navbar')

<main class="flex-1 container mx-auto px-6 py-8">
    {{-- Mensagens de sessão --}}
    @include('components.flash-messages')

    {{-- Conteúdo dinâmico --}}
    @yield('content')
</main>

{{-- Rodapé opcional --}}
{{-- <footer class="text-center text-sm text-gray-500 py-4">
    &copy; {{ date('Y') }} Meu App. Todos os direitos reservados.
</footer> --}}


</body>
</html>
