<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
use App\Models\UserContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContentController extends Controller
{
    public function save(int $adventureId, int $contentId): RedirectResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();

        UserContent::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'adventure_id' => $adventure->id,
            'content_id' => $contentId,
        ]);

        return redirect()->route('play', ['slug' => $adventure->slug]);
    }

    public function delete(int $adventureId, int $contentId): RedirectResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();

        UserContent::query()->where([
            'user_id' => auth()->id(),
            'adventure_id' => $adventure->id,
            'content_id' => $contentId,
        ])->delete();

        return redirect()->route('play', ['slug' => $adventure->slug]);
    }

    public function contents(int $adventureId, int $contentId): JsonResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();
        $contents = ContentHelper::get($adventure->id, $contentId);

        return response()->json($contents);
    }
}
