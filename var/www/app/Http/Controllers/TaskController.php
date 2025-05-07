<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(): Collection
    {
        return Task::with(['board'])->get();
    }

    public function store(Request $request, Board $board): RedirectResponse
    {
        $validatedFields = $request->validate([
            'status_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'position' => 'nullable|integer',
            'assigned_to' => 'nullable|integer',
        ]);
        $validatedFields['created_by'] = auth()->id();
        removeEmptyOptionalFields(Task::OPTIONAL_FIELDS, $validatedFields);

        $task = $board->tasks()->create($validatedFields);
        return redirect()->route('boards.show', $board)->with('success', 'Tarefa ' . $task->title . ' criada!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request, Board $board, Task $task): RedirectResponse
    {
        $validatedFields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'position' => 'nullable|integer',
            'assigned_to' => 'nullable|integer',
        ]);
        removeEmptyOptionalFields(Task::OPTIONAL_FIELDS, $validatedFields);
        $task->update($validatedFields);

        return redirect()->route('boards.show', $board)->with('success', 'Tarefa ' . $task->title . ' atualizada!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('boards.show', $board)
            ->with('success', 'Deleted Task: ' . $task->title . ' successfully!');
    }
}
