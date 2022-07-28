<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'creator_id',
        'opponent_id',
        'grid',
        'game_finished',
        'creator_win',
        'schedulet_at',
        'state'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
    public function opponent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'oppenent_id', 'id');
    }
}
