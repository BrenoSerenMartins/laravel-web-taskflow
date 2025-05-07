<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function index(): Collection
    {
        return Status::with(['board', 'tasks'])->get();
    }

    public function store(Board $board, Request $request): RedirectResponse
    {
        $validatedFields = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:25',
            'order' => 'nullable|integer',
        ]);
        removeEmptyOptionalFields(Status::OPTIONAL_FIELDS, $validatedFields);
        $board->statuses()->create($validatedFields);

        return redirect()->route('boards.show', $board)
            ->with('success', 'Status: ' . $request->input('name') . ' successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    public function update(Request $request, Board $board, Status $status): RedirectResponse
    {
        $validatedFields = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|integer'
        ]);
        removeEmptyOptionalFields(Status::OPTIONAL_FIELDS, $validatedFields);
        $status->update($validatedFields);

        return redirect()->route('boards.show', $board)
            ->with('success', 'Updated Status: ' . $request->input('name') . ' successfully!');
    }

    public function destroy(Board $board, Status $status): RedirectResponse
    {
        $status->delete();
        return redirect()->route('boards.show', $board)
            ->with('success', 'Deleted Status: ' . $status->name . ' successfully!');
    }
}
