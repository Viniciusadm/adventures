<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
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
}
