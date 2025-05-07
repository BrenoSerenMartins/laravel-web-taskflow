<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    const OPTIONAL_FIELDS = [
        'created_by',
        'assigned_to',
        'description',
        'position',
        'color'
    ];

    protected $fillable = [
        'board_id',
        'status_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'position',
        'color'
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')
            ->withDefault([
                'id' => 0,
                'name' => 'unknown'
            ]);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to')
            ->withDefault([
                'id' => 0,
                'name' => 'unassigned'
                ]);
    }
}
