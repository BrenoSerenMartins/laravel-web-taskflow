<?php

namespace App\Services;

use App\Models\Status;
use Illuminate\Support\Facades\DB;

class StatusService
{
    public function create($board, $statusData): Status
    {
        removeEmptyOptionalFields(Status::OPTIONAL_FIELDS, $statusData);
        return $board->statuses()->create($statusData);
    }

    public function update($statusData, Status $status): Status
    {
        removeEmptyOptionalFields(Status::OPTIONAL_UPDATE_FIELDS, $statusData);
        $status->update($statusData);
        return $status;
    }

    public function reorderStatuses(array $reorderData, $board): void
    {
        $statusesPosition = $reorderData['statusesPosition'];

        DB::transaction(function () use ($statusesPosition, $board) {
            foreach ($statusesPosition as $index => $statusId) {
                $status = $board->statuses()->where('id', $statusId)->first();

                if (!empty($status)) {
                    $status->update(['position' => $index]);
                }
            }
        });
    }
}
