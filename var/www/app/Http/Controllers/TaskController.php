<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\ReorderTaskRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Board;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function store(StoreTaskRequest $request, Board $board): RedirectResponse
    {
        $task = $this->taskService->create($request->validated(), $board);

        return to_route('boards.show', $board)
            ->with('success', "Tarefa {$task->title} criada!");
    }

    public function update(UpdateTaskRequest $request, Board $board, Task $task): RedirectResponse
    {
        $this->taskService->update($task, $request->validated());

        return to_route('boards.show', $board)
            ->with('success', "Tarefa {$task->title} atualizada!");
    }

    public function reorder(ReorderTaskRequest $request, Board $board): JsonResponse
    {
        $this->taskService->reorderTasks($request->validated(), $board);

        return response()->json(['message' => 'Tarefas reordenadas com sucesso.']);
    }

    public function destroy(Board $board, Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('boards.show', $board)
            ->with('success', "Deleted Task: {$task->title} successfully!");
    }
}
