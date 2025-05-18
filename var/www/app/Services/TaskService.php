<?php
namespace App\Services;

use App\Models\Task;
use App\Models\Board;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function create(array $taskData, Board $board): Task
    {
        $taskData['created_by'] = auth()->id();
        $taskData['position'] = $this->getNextPosition($taskData);
        removeEmptyOptionalFields(Task::OPTIONAL_FIELDS, $taskData);

        return $board->tasks()->create($taskData);
    }

    public function update(Task $task, array $changedTaskData): Task
    {
        removeEmptyOptionalFields(Task::OPTIONAL_FIELDS, $changedTaskData);
        $task->update($changedTaskData);

        return $task;
    }

    public function reorderTasks(array $reorderData, $board): void
    {
        $newTasksOrder = $reorderData['tasksPosition'];
        $statusId = $reorderData['status_id'];

        DB::transaction(function () use ($newTasksOrder, $statusId, $board) {
            foreach ($newTasksOrder as $index => $taskId) {
                Task::where('id', $taskId)
                    ->where('board_id', $board->id)
                    ->update([
                        'position' => $index,
                        'status_id' => $statusId
                    ]);
            }
        });
    }

    private function getNextPosition(array $taskData): int
    {
        if (!empty($taskData['position'])) {
            return $taskData['position'];
        }
        return (int)Task::where('status_id', $taskData['status_id'])->max('position') + 1;
    }




}
