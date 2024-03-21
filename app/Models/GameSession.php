<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    /**
     * Get the score of the GameSession
     *
     * @return Attribute
     */
    protected function calculateScore(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['retries'] > 0 
            ? round(self::SCORE_MULTIPLIER * ($attributes['number_of_pairs'] / $attributes['retries'])) 
            : 0,
        );
    }

}
