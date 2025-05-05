@extends('layouts.app')

@section('title', $board->name)

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">{{ $board->name }}</h1>

        <!-- Add New Status Button -->
        <div x-data="{ showForm: false }" class="relative">
            <button @click="showForm = !showForm"
                    class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/> </svg>
            </button>

            <!-- Add Form -->
            <form x-show="showForm" @click.away="showForm = false" method="POST" action="{{ route('boards.statuses.store', $board) }}"
                  class="absolute right-0 mt-2 bg-white shadow-lg rounded p-4 space-y-2 w-64 z-50">
                @csrf
                <input type="text" name="name" placeholder="Status name"
                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:border-blue-300" required>
                <input type="text" name="color" placeholder="#ffffff"
                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:border-blue-300">
                <button type="submit"
                        class="bg-blue-600 text-white w-full py-1 rounded hover:bg-blue-700 transition">
                    Add
                </button>
            </form>
        </div>
    </div>

    <!-- Status Columns -->
    <div class="flex space-x-4 overflow-x-auto scroll-smooth">
        @foreach($board->statuses as $status)
            <div class="status-column relative rounded shadow p-4 min-w-[16rem] flex-shrink-0 group"
                 style="background-color: {{ $status->color }}">

                <!-- Edit/Delete Buttons (only on hover) -->
                <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition">
                    <!-- Edit Modal -->
                    <x-modal title="Edit Status" :open="false">
                        <x-slot:trigger>
                            <svg class="w-5 h-5 text-gray-500 hover:text-blue-600 cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </x-slot:trigger>

                        <form method="POST" action="{{ route('boards.statuses.update', [$board, $status]) }}" class="space-y-2">
                            @csrf
                            @method('PUT')

                            <input type="text" name="name" value="{{ $status->name }}" class="w-full border rounded p-2" required>
                            <input type="text" name="color" value="{{ $status->color }}" class="w-full border rounded p-2">
                            <input type="number" name="order" value="{{ $status->order }}" class="w-full border rounded p-2">
                            <button type="submit" class="mt-2 bg-blue-600 text-white w-full py-2 rounded">Save</button>
                        </form>
                    </x-modal>

                    <!-- Delete -->
                    <form method="POST" action="{{ route('boards.statuses.destroy', [$board, $status]) }}">
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

                <!-- Status Title -->
                <h2 class="font-semibold text-lg mb-2">{{ $status->name }}</h2>

                <!-- Tasks -->
                <div class="tasks-div space-y-2 max-h-80 overflow-y-auto pr-2 scroll-hide scroll-smooth">
                    <div class="task bg-gray-100 p-2 rounded">Task 1</div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<style>
    .scroll-hide::-webkit-scrollbar {
        display: none;
    }
    .scroll-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
