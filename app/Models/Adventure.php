<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Adventure
 * @package App\Models
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 */
class Adventure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
    ];

    public function firstContent(): HasOne
    {
        return $this->hasOne(Content::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
