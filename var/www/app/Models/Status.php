<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    protected $fillable = [
        'name',
        'color',
        'order'
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
