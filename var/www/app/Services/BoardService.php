<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Boards\UpdateBoardRequest;
use App\Models\Board;

class BoardService
{
    public function create(array $boardData): Board
    {
        removeEmptyOptionalFields(Board::OPTIONAL_FIELDS, $boardData);

        return Board::create($boardData);
    }

    public function update(Board $board, array $boardData): Board
    {
        removeEmptyOptionalFields(Board::OPTIONAL_FIELDS, $boardData);
        $board->update($boardData);

        return $board;
    }
}
