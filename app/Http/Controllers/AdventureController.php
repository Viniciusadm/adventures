<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\UserProgress;
use Illuminate\Http\RedirectResponse;

class AdventureController extends Controller
{
    public function save(int $adventureId, int $contentId): RedirectResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();

        UserProgress::query()
            ->where('user_id', auth()->id())
            ->where('adventure_id', $adventure->id)
            ->update(['content_id' => $contentId]);

        return redirect()->route('play', ['slug' => $adventure->slug]);
    }
}
