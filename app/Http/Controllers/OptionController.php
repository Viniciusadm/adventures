<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\Content;
use App\Models\OptionsChoice;
use Illuminate\Http\RedirectResponse;

class OptionController extends Controller
{

    public function save(int $contentId, int $optionId): RedirectResponse
    {
        $content = Content::query()->find($contentId);
        $adventure = Adventure::query()->find($content->adventure_id);

        OptionsChoice::query()->where([
            'content_id' => $contentId,
            'user_id' => auth()->id(),
        ])->delete();

        OptionsChoice::query()->create([
            'content_id' => $contentId,
            'option_id' => $optionId,
            'user_id' => auth()->id(),
            'adventure_id' => $adventure->id,
        ]);

        return redirect()->route('play', ['slug' => $adventure->slug]);
    }
}
