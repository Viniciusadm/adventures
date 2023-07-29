<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
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
        $contents = ContentHelper::get($adventure->id);

        return inertia('Play', [
            'adventure' => $adventure,
            'contents' => $contents,
        ]);
    }
}
