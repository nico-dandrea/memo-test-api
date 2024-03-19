<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\GameSessionEnded;

class GameSession extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    const SCORE_MULTIPLIER = 100;

    /**
     * Get the MemoTest that owns the GameSession
     *
     * @return BelongsTo
     */
    public function memoTest(): BelongsTo
    {
        return $this->belongsTo(MemoTest::class);
    }

}
