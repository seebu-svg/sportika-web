<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(6),
            'excerpt' => fake()->sentence(16),
            'content' => '<p>'.implode('</p><p>', fake()->paragraphs(6)).'</p>',
            'status' => 'published',
            'is_featured' => false,
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'meta_title' => null,
            'meta_description' => null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
