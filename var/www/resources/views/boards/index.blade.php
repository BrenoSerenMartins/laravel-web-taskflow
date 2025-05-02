@extends('layouts.app')

@section('title', 'Boards')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Boards</h1>
        <form action="{{route('board.store')}}" method="POST" class="flex items-center space-x-2">
            @csrf
            <input type="text" name="name" placeholder="Nome da nova board"
                   class="border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:border-blue-300"
                   required>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
                Criar
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($boards as $board)
            <div class="bg-white shadow rounded p-4 border border-gray-200 relative">
                <div class="absolute top-2 right-2 flex space-x-2">
                    <x-modal title="Edit Board" :open="false">
                        <x-slot:trigger>
                            <svg class="w-5 h-5 text-gray-500 hover:text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </x-slot:trigger>

                        <!-- Modal content -->
                        <form method="POST" action="{{ route('board.update', $board) }}">
                            @csrf
                            @method('PUT')

                            <label class="block text-sm mb-2">Board Name</label>
                            <input type="text" name="name" value="{{ $board->name }}" class="w-full border rounded p-2"
                                   required>

                            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                        </form>
                    </x-modal>

                    <form method="POST" action="{{ route('board.destroy', $board) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-600" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <h2 class="text-lg font-semibold">{{ $board->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">ID: {{ $board->id }}</p>

                <a href="#" class="text-blue-600 text-sm mt-3 inline-block hover:underline">
                    View Board
                </a>
            </div>
        @endforeach


    </div>
@endsection
