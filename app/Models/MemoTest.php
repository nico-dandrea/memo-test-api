<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MemoTest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $with = ['images'];

    /**
     * Get all of the images for the MemoTest
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(MemoTestImage::class);
    }

    /**
     * Get all of the sessions for the MemoTest
     *
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }

    /**
     * Get the max score for the MemoTest of all sessions
     *
     * @return HasOne
     */
    public function maxScore(): HasOne
    {
        return $this->hasOne(GameSession::class)->orderByDesc('score');
    }
}
