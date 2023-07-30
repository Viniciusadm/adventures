<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserProgress
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $adventure_id
 * @property int $content_id
 */
class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'adventure_id',
        'content_id',
    ];
}
