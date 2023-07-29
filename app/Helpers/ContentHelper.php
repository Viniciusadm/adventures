<?php

namespace App\Helpers;

use App\Models\Content;
use App\Models\Option;

class ContentHelper
{
    /**
     * @param int $adventureId
     * @param int $contentId
     * @return Content[]
     */
    public static function get(int $adventureId, int $contentId = 0): array
    {
        $contents = [];

        /** @var Content $firstContent */
        $query = Content::query()
            ->where('adventure_id', $adventureId);

        if ($contentId) {
            $query->where('id', $contentId);
        }

        $firstContent = $query->first();

        if ($firstContent) {
            $contents = [$firstContent];
            $nextContent = $firstContent->nextContent;

            for ($i = 0; $i < 10; $i++) {
                $contents[] = $nextContent;

                if ($nextContent->nextContent) {
                    $nextContent = $nextContent->nextContent;
                } else if ($nextContent->options->count()) {
                    $options = Option::query()->where('content_id', $nextContent->id)->with('nextContent')->get();
                    $contents[$i + 1]['options'] = $options;
                    break;
                } else {
                    break;
                }
            }
        }

        return $contents;
    }
}
