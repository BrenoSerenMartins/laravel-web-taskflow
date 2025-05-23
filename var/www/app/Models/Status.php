<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    const OPTIONAL_FIELDS = [
        'color',
        'position',
    ];
    const OPTIONAL_UPDATE_FIELDS = [
        'name',
        'color',
        'position',
    ];

    protected $fillable = [
        'name',
        'position'
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
