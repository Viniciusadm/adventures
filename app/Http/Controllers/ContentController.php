<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Models\Adventure;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function contents(int $adventureId, int $contentId): JsonResponse
    {
        $adventure = Adventure::query()->where('id', $adventureId)->firstOrFail();
        $contents = ContentHelper::get($adventure->id, $contentId);

        return response()->json($contents);
    }
}
