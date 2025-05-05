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
        return Status::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Board $board, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:25',
            'order' => 'nullable|integer',
        ]);
        $statusData['name'] = $request->input('name');
        if($request->input('color')) {
            $statusData['color'] = $request->input('color');
        }
        if($request->input('order')) {
            $statusData['order'] = $request->input('order');
        }
        $board->statuses()->create($statusData);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:25',
            'order' => 'nullable|integer'
        ]);
        $statusData['name'] = $request->input('name');
        if($request->input('color')) {
            $statusData['color'] = $request->input('color');
        }
        if($request->input('order')) {
            $statusData['order'] = $request->input('order');
        }
        $status->update($statusData);
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
