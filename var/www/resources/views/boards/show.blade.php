@extends('layouts.app')

@section('title', $board->name)

@section('content')
    <div
        x-data
        x-init="
        // Sortable das colunas (se você já tiver, mantenha)
        Sortable.create($refs.columnsContainer, {
            animation: 150,
            handle: '.drag-handle', // se tiver
            onEnd: async (evt) => {
                const statusesPosition = Array.from(evt.to.children).map(col => col.dataset.id);

                await fetch('{{ route('boards.statuses.reorder', ['board' => $board->id]) }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ statusesPosition })
                });
            }
        });

        // Sortable das tarefas (em cada coluna)
        Array.from($refs.columnsContainer.children).forEach(column => {
            const columnId = column.dataset.id;
            const taskContainer = column.querySelector('[x-ref^=\'tasksContainer\']');

            Sortable.create(taskContainer, {
                group: 'shared-tasks',
                animation: 150,
                onEnd: async (evt) => {
                    const taskElements = Array.from(evt.to.children);
                    const tasksPosition = taskElements.map(el => el.dataset.id);
                    const newStatusId = evt.to.closest('[data-id]')?.dataset.id;

                    await fetch('{{ route('boards.tasks.reorder', ['board' => $board->id]) }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            tasksPosition,
                            status_id: newStatusId,
                        })
                    });
                }
            });
        });

    "
    >

        <div class="container mx-auto px-4 ">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between mb-8 gap-4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $board->name }}</h1>

                <!-- Add Status -->
                <div x-data="{ showForm: false }" class="relative">
                    <button @click="showForm = !showForm"
                            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>

                    <!-- Add Status Form -->
                    <form x-show="showForm" @click.away="showForm = false" method="POST"
                          action="{{ route('boards.statuses.store', $board) }}"
                          class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg p-4 w-72 z-50 space-y-3"
                          x-transition>
                        @csrf
                        <input type="text" name="name" placeholder="Status name"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                               required>
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                            Add Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Status Columns -->
            <div class="flex min-w-fit gap-6 max-auto" x-ref="columnsContainer">
                @foreach($board->statuses->sortBy('position') as $status)
                    <div class="w-64 shrink-0 bg-white rounded shadow p-4" data-id="{{ $status->id }}">

                        <div x-data="{ open: false }" class="flex items-center justify-between mb-2">

                            <!-- Drag handle -->
                            <div class="drag-handle cursor-move text-gray-400 hover:text-gray-600">
                                <span class="material-symbols-outlined">drag_handle</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700">{{ $status->name }}</h2>
                            </div>

                            <div>
                                <!-- Botão de edição -->
                                <button @click="open = true"
                                        class="text-gray-500 hover:text-blue-600 transition">
                                <span
                                    class="material-symbols-outlined text-gray-600 hover:text-blue-600 cursor-pointer text-[20px]">edit_square</span>

                                </button>
                                <!-- Botão de Exclusão -->
                                <button @click.prevent="$refs.deleteForm{{$status->id}}.submit()"
                                        class="text-gray-500 hover:text-red-600 transition">
                                    <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                                </button>
                                <!-- Form de exclusão ativado remotamente pelo botão -->
                                <form x-ref="deleteForm{{$status->id}}" method="POST"
                                      action="{{ route('boards.statuses.destroy', [$board, $status]) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            <!-- Modal de edição -->
                            <div x-show="open" x-cloak
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div @click.away="open = false"
                                     class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                                    <button @click="open = false"
                                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>

                                    <h3 class="text-lg font-bold mb-4">Editar Coluna</h3>

                                    <form method="POST"
                                          action="{{ route('boards.statuses.update', [$board, $status]) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-3">
                                            <input type="text" name="name" value="{{ $status->name }}"
                                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                                                   required>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="open = false"
                                                        class="px-4 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                                                    Cancelar
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                    Salvar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks -->
                        <div class="space-y-2" x-ref="tasksContainer-{{ $status->id }}">
                            @foreach($status->tasks->sortBy('position') as $task)
                                <div x-data="{ open: false, editing: false }" class="relative"
                                     data-id="{{ $task->id }}">
                                    <!-- Trigger -->
                                    <div @click="open = true"
                                         class="cursor-pointer bg-gray-100 rounded p-3 shadow-sm hover:bg-gray-200 transition">
                                        <h3 class="font-medium text-gray-800">{{ $task->title }}</h3>
                                    </div>

                                    <!-- Modal -->
                                    <div x-show="open" x-cloak
                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="open = false"
                                             class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative space-y-4">
                                            <!-- Close -->
                                            <button @click="open = false"
                                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>

                                            <!-- Task Info / Edit Mode -->
                                            <template x-if="!editing">
                                                <div>
                                                    <h3 class="text-xl font-bold">{{ $task->title }}</h3>
                                                    <p class="text-gray-600 mt-1">{{ $task->description }}</p>

                                                    <button @click="editing = true"
                                                            class="mt-4 px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                        Editar
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Edit Mode -->
                                            <template x-if="editing">
                                                <form method="POST"
                                                      action="{{ route('boards.tasks.update', [$board, $task]) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Botões -->
                                                    <div class="space-y-2">
                                                        <input name="status_id" value="{{ $status->id }}"
                                                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                                                               hidden/>
                                                        <input name="title" value="{{ $task->title }}"
                                                               placeholder="Task Title"
                                                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"/>

                                                        <textarea name="description" placeholder="Task Description"
                                                                  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">{{ $task->description }}</textarea>
                                                        <div class="flex justify-between items-center mt-3">
                                                            <div class="flex space-x-2">
                                                                <!-- Botão de Exclusão -->
                                                                <button @click.prevent="$refs.deleteForm.submit()"
                                                                        class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                                    Delete
                                                                </button>
                                                                <!-- Form de exclusão ativado remotamente pelo botão -->
                                                                <form x-ref="deleteForm" method="POST"
                                                                      action="{{ route('boards.tasks.destroy', [$board, $task]) }}"
                                                                      class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                            <div class="flex space-x-2">
                                                                <!-- Botões Cancelar e Salvar à direita -->
                                                                <button type="button" @click="editing = false"
                                                                        class="px-4 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                                                                    Cancelar
                                                                </button>
                                                                <button type="submit"
                                                                        class="px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <!-- Add Task Button & Modal -->
                        <div x-data="{ openModal: false }" class="mt-4">
                            <button @click="openModal = true"
                                    class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                                + Add Task
                            </button>

                            <!-- Modal -->
                            <div x-show="openModal" x-cloak
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div @click.away="openModal = false"
                                     class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative">
                                    <!-- Close Button -->
                                    <button @click="openModal = false"
                                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>

                                    <h3 class="text-xl font-semibold mb-4">Add Task</h3>
                                    <form method="POST" action="{{ route('boards.tasks.store', $board) }}"
                                          class="space-y-3">
                                        @csrf
                                        <input name="status_id" value="{{ $status->id }}"
                                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                                               hidden/>
                                        <input type="text" name="title" placeholder="Task title"
                                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                                               required>
                                        <textarea name="description" placeholder="Task Description"
                                                  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"></textarea>
                                        <button type="submit"
                                                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                                            Create Task
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
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

<script type="text/javascript">
    function setAction(url) {
        document.getElementById('dynamicForm').action = url;
    }
</script>


