@extends('layouts.app')
@section('title', $title)
@section('content')
        <!-- Conteúdo principal -->
        <main class="flex-1 p-6 overflow-auto">
            <h1 class="text-3xl font-bold mb-6">Kanban - Projeto X</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Coluna: A Fazer -->
                <section class="bg-white rounded-xl shadow p-4">
                    <h2 class="text-lg font-semibold mb-4 text-blue-600">📋 A Fazer</h2>
                    <div class="space-y-4">
                        <div class="bg-blue-100 p-4 rounded shadow">
                            <h3 class="font-medium">Criar layout inicial</h3>
                            <p class="text-sm text-gray-600">Definir estrutura base do app</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded shadow">
                            <h3 class="font-medium">Integrar Tailwind</h3>
                            <p class="text-sm text-gray-600">Usar CDN por enquanto</p>
                        </div>
                    </div>
                </section>

                <!-- Coluna: Em Progresso -->
                <section class="bg-white rounded-xl shadow p-4">
                    <h2 class="text-lg font-semibold mb-4 text-yellow-600">🚧 Em Progresso</h2>
                    <div class="space-y-4">
                        <div class="bg-yellow-100 p-4 rounded shadow">
                            <h3 class="font-medium">Criar modelo de tarefa</h3>
                            <p class="text-sm text-gray-600">Modelo no banco e controller</p>
                        </div>
                    </div>
                </section>

                <!-- Coluna: Concluído -->
                <section class="bg-white rounded-xl shadow p-4">
                    <h2 class="text-lg font-semibold mb-4 text-green-600">✅ Concluído</h2>
                    <div class="space-y-4">
                        <div class="bg-green-100 p-4 rounded shadow">
                            <h3 class="font-medium">Instalar Laravel</h3>
                            <p class="text-sm text-gray-600">Projeto inicial criado</p>
                        </div>
                    </div>
                </section>

            </div>
        </main>
@endsection

