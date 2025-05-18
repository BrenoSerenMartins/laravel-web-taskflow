@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Bem-vindo ao seu Dashboard, {{ auth()->user()->name }}!</h1>

        <p class="mb-4">
            Aqui você pode ver suas informações e acessar funcionalidades do seu perfil.
        </p>

        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-semibold mb-4">Informações do Usuário</h2>
            <ul>
                <li><strong>Nome:</strong> {{ auth()->user()->name }}</li>
                <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                <li><strong>Cadastrado em:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</li>
            </ul>
        </div>

        <div class="mt-6">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-red-600 hover:underline">
                Sair
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
@endsection
