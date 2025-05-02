<?php
/**
 * TaskFlow - Task Management System
 *
 * @package TaskFlow
 * @author Breno Seren Martins <brenosm.dev@gmail.com>
 * @license Apache 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @version 1.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }

    // Relacionamento com as colunas (1:N)
//    public function columns()
//    {
//        return $this->hasMany(Column::class);  // Uma Board tem muitas colunas
//    }
}
