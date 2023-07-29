<?php

namespace App\Http\Controllers;

use Inertia\Response;

class SiteController extends Controller
{
    public function index(): Response
    {
        return inertia('Home');
    }
}
