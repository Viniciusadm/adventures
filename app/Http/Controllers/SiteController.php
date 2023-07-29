<?php

namespace App\Http\Controllers;

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

        return inertia('Play', [
            'adventure' => $adventure,
        ]);
    }
}
