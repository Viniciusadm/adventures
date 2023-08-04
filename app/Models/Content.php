<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Content
 * @package App\Models
 *
 * @property int $id
 * @property int $adventure_id
 * @property int $next_content_id
 * @property string $body
 * @property Adventure $adventure
 * @property Content $nextContent
 * @property Option[] $options
 */
class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'adventure_id',
        'next_content_id',
        'body',
        'type',
    ];

    public function adventure(): BelongsTo
    {
        return $this->belongsTo(Adventure::class);
    }

    public function nextContent(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function userContents(): HasMany
    {
        return $this->hasMany(UserContent::class);
    }
}
