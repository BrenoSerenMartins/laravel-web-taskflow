@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="bg-gray-100 min-h-screen flex flex-col justify-center items-center px-6 py-16">
        <div class="max-w-4xl text-center">
            <h1 class="text-5xl font-extrabold mb-6 text-gray-900">
                Bem-vindo ao <span class="text-indigo-600">Seu Projeto</span>
            </h1>
            <p class="text-lg text-gray-700 mb-8">
                Uma plataforma incrível para transformar suas ideias em realidade. Explore funcionalidades, conecte-se com outros usuários e aproveite uma experiência única.
            </p>
            <div class="flex justify-center gap-4">
                @guest
                    <a href="{{ route('login.show') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Entrar
                    </a>
                    <a href="{{ route('register.show') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                        Criar Conta
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Ir para Dashboard
                    </a>
                @endguest
            </div>
        </div>

    </section>
@endsection
