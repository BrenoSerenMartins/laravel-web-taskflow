<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statuses\ReorderStatusRequest;
use App\Http\Requests\Statuses\StoreStatusRequest;
use App\Http\Requests\Statuses\UpdateStatusRequest;
use App\Models\Board;
use App\Models\Status;
use App\Services\StatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct(protected StatusService $statusService)
    {
    }

    public function store(Board $board, StoreStatusRequest $request): RedirectResponse
    {
        $this->statusService->create($board, $request->validated());

        return to_route('boards.show', $board)
            ->with('success', "Status: {$request->input('name')} successfully!");
    }

    public function update(UpdateStatusRequest $request, Board $board, Status $status): RedirectResponse
    {
        $this->statusService->update($request->validated(), $status);

        return to_route('boards.show', $board)
            ->with('success', "Updated Status: {$request->input('name')} successfully!");
    }

    public function reorder(ReorderStatusRequest $request, Board $board): JsonResponse
    {
        $this->statusService->reorderStatuses($request->validated(), $board);

        return response()->json(['success' => true]);
    }


    public function destroy(Board $board, Status $status): RedirectResponse
    {
        $status->delete();

        return to_route('boards.show', $board)
            ->with('success', "Deleted Status: {$status->name} successfully!");
    }
}
