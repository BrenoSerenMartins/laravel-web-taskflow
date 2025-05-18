<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Boards\StoreBoardRequest;
use App\Http\Requests\Boards\UpdateBoardRequest;
use App\Models\Board;
use App\Services\BoardService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class BoardController extends Controller
{

    public function __construct(protected BoardService $boardService) {}
    public function index(): View|Application|Factory
    {
        $boards = Board::with(['statuses', 'tasks'])->get();

        return view('boards.index', compact('boards'));
    }

    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $board = $this->boardService->create($request->validated());

        return to_route('boards.index')
            ->with('success', "Board: {$board->name} created successfully!");
    }

    public function show(Board $board): View|Application|Factory
    {
        return view('boards.show', compact('board'));
    }

    public function update(UpdateBoardRequest $request, Board $board): RedirectResponse
    {
        $this->boardService->update($board, $request->validated());

        return to_route('boards.index')
            ->with('success', "Board: {$board->name} updated successfully!");
    }

    public function destroy(Board $board): RedirectResponse
    {
        $board->delete();

        return to_route('boards.index')
            ->with('success', "Board: {$board->name} was deleted successfully!");
    }
}
