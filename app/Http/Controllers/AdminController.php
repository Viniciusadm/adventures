<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
use App\Models\Content;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        return inertia('admin/Home');
    }

    public function adventures(): Response
    {
        $adventures = Adventure::query()->get();

        return inertia('admin/Adventures', [
            'adventures' => $adventures
        ]);
    }

    public function adventure(string $slug): Response
    {
        $adventure = Adventure::query()
            ->where('slug', $slug)
            ->firstOrFail();

        return inertia('admin/Adventure', [
            'adventure' => $adventure
        ]);
    }
}
