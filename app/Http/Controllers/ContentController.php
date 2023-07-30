<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContentController extends Controller
{
    public function contents(int $adventureId, int $contentId): JsonResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();
        $contents = ContentHelper::get($adventure->id, $contentId);

        return response()->json($contents);
    }

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
