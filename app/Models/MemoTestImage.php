<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemoTestImage extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the MemoTest that owns the MemoTestImage
     *
     * @return BelongSto
     */
    public function memoTest(): BelongsTo
    {
        return $this->belongsTo(MemoTest::class);
    }
}
