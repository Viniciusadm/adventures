<?php

namespace Database\Factories;

use App\Models\Adventure;
use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'adventure_id' => Adventure::query()->inRandomOrder()->first()->id,
            'body' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['narrator', 'self', 'character']),
        ];
    }
}
