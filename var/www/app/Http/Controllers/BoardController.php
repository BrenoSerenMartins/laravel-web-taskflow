<?php
/**
 * TaskFlow - Task Management System
 *
 * @package TaskFlow
 * @author Breno Seren Martins <brenosm.dev@gmail.com>
 * @license Apache 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function index(): View|Application|Factory
    {
        $boards = Board::all();
        return view('boards.index', compact('boards'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::create([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('boards.index')->with('success', 'Board: ' . $board->name . ' created successfully!');
    }

    public function update(Request $request, Board $board): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $board->update([
            'name' => $request->input('name'),
        ]);
        $board->save();

        return redirect()->route('boards.index')->with('success', 'Board: ' . $board->name . ' updated successfully!');
    }

    public function destroy(Board $board): RedirectResponse
    {
        $board->delete();
        return redirect()->route('boards.index')->with('success', 'Board: ' . $board->name . ' was deleted successfully!');
    }
}
