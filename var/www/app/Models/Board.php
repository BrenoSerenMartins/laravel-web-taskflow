<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    const OPTIONAL_FIELDS = [
        'color',
    ];

    protected $fillable = [
        'name',
        'color',
        'user_id'
    ];

//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
