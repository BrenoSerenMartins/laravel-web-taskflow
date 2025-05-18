@extends('layouts.app')

@section('title', 'Boards')

@section('content')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Boards</h1>

        <div x-data="{ showForm: false }" class="relative">
            <button @click="showForm = !showForm"
                    class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition">
                <span class="material-symbols-outlined">add</span>
            </button>

            <!-- Add Form -->
            <form x-show="showForm"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-95"
                  @click.away="showForm = false"
                  method="POST" action="{{ route('boards.store') }}"
                  class="absolute right-0 mt-2 bg-white shadow-lg rounded p-4 space-y-2 w-64 z-50">
                @csrf
                <input type="text" name="name" placeholder="Board name"
                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:border-blue-300"
                       required>
                <input type="text" name="color" placeholder="#ffffff"
                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:border-blue-300">
                <button type="submit"
                        class="bg-blue-600 text-white w-full py-1 rounded hover:bg-blue-700 transition">
                    Add
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($boards as $board)
            <div class="bg-white shadow rounded p-4 border border-gray-200 relative overflow-hidden"
                 style="background-color: {{ $board->color }}">
                <div class="absolute top-2 right-2 flex space-x-2 z-20">
                    {{-- Modal de edição --}}
                    <x-modal title="Edit Board" :open="false">
                        <x-slot:trigger>
                            <span
                                class="material-symbols-outlined text-gray-600 hover:text-blue-600 cursor-pointer text-[20px]">edit_square</span>
                        </x-slot:trigger>

                        <form method="POST" action="{{ route('boards.update', $board) }}">
                            @csrf
                            @method('PUT')

                            <label class="block text-sm mb-2">Board Name</label>
                            <input type="text" name="name" value="{{ $board->name }}"
                                   class="w-full border rounded p-2 mb-2" required>
                            <input type="text" name="color" value="{{ $board->color }}"
                                   class="w-full border rounded p-2 mb-2">

                            <button type="submit"
                                    class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Save
                            </button>
                        </form>
                    </x-modal>

                    {{-- Botão delete --}}
                    <form method="POST" action="{{ route('boards.destroy', $board) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-600" title="Delete">
                            <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                        </button>
                    </form>
                </div>

                {{-- Conteúdo do card --}}
                <h2 class="text-lg font-semibold text-gray-800">{{ $board->name }}</h2>
                <p class="text-sm text-gray-700 mt-1">ID: {{ $board->id }}</p>

                <a href="{{ route('boards.show', $board) }}"
                   class="text-blue-700 text-sm mt-3 inline-block hover:underline font-medium">
                    View Board
                </a>
            </div>
        @endforeach
    </div>
@endsection
