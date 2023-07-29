<?php

namespace App\Helpers;

use App\Models\Content;

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
            while ($nextContent && count($contents) < 6) {
                $contents[] = $nextContent;
                $nextContent = $nextContent->nextContent;
            }
        }

        return $contents;
    }
}
