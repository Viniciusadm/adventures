<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionsChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id',
        'user_id',
        'adventure_id',
        'content_id',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
