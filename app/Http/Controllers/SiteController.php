<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
use App\Models\UserProgress;
use Inertia\Response;

class SiteController extends Controller
{
    public function index(): Response
    {
        $adventures = Adventure::query()->get();
        return inertia('Home', [
            'adventures' => $adventures,
        ]);
    }

    public function play(string $slug): Response
    {
        $adventure = Adventure::query()->where('slug', $slug)->firstOrFail();

        /** @var UserProgress $progress */
        $progress = UserProgress::query()
            ->where('user_id', auth()->id())
            ->where('adventure_id', $adventure->id)
            ->firstOrCreate([
                'user_id' => auth()->id(),
                'adventure_id' => $adventure->id,
            ]);

        $contents = ContentHelper::get($adventure->id, $progress->content_id);

        return inertia('Play', [
            'adventure' => $adventure,
            'contents' => $contents,
        ]);
    }
}
