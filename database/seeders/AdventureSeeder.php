<?php

namespace Database\Seeders;

use App\Models\Adventure;
use App\Models\Content;
use App\Models\Option;
use Illuminate\Database\Seeder;

class AdventureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Adventure::factory()->count(10)->create() as $adventure) {
            $this->addContent($adventure->id);
        }
    }

    private function addContent(int $adventureId, int $contentId = null): void
    {
        if (!$contentId) {
            $last = Content::factory()->create([
                'adventure_id' => $adventureId,
            ]);
        } else {
            $last = Content::query()
                ->where('adventure_id', $adventureId)
                ->where('id', $contentId)
                ->first();
        }

        $quantity = rand(3, 6);

        for ($i = 0; $i < $quantity; $i++) {
            $now = Content::factory()->create([
                'adventure_id' => $adventureId,
            ]);

            $last->update([
                'next_content_id' => $now->id,
            ]);

            $last = $now;
        }

        $this->addOptions($adventureId, $last->id);
    }

    private function addOptions(int $adventureId, int $contentId): void
    {
        $quantity = rand(2, 4);

        for ($i = 0; $i < $quantity; $i++) {
            $content = Content::factory()->create([
                'adventure_id' => $adventureId,
            ]);

            Option::factory()->create([
                'content_id' => $contentId,
                'next_content_id' => $content->id,
            ]);

            $this->addContentOrOption($adventureId, $content->id);
        }
    }

    private function addContentOrOption(int $adventureId, int $contentId): void
    {
        $options = ['content', 'option', 'none', 'none', 'none', 'none'];
        $sort = array_rand($options);
        $option = $options[$sort];

        $count = Content::query()
            ->where('adventure_id', $adventureId)
            ->count();

        if ($count > 30) {
            return;
        }

        if ($option === 'content') {
            $this->addContent($adventureId, $contentId);
        } elseif ($option === 'option') {
            $this->addOptions($adventureId, $contentId);
        }
    }
}
