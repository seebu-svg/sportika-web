<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    public function definition(): array
    {
        $positions = Player::POSITIONS;
        $feet = Player::FEET;

        return [
            'name' => fake()->unique()->name(),
            'position' => fake()->randomElement($positions),
            'jersey_number' => fake()->numberBetween(1, 45),
            'nationality' => fake()->country(),
            'date_of_birth' => fake()->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
            'height_cm' => fake()->numberBetween(168, 200),
            'weight_kg' => fake()->numberBetween(62, 95),
            'preferred_foot' => fake()->randomElement($feet),
            'current_club' => fake()->randomElement(['FC Dynamo', 'Real Norte', 'Athletic Kings', 'Union Star', 'Olympic FC']),
            'short_description' => fake()->sentence(10),
            'bio' => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'appearances' => fake()->numberBetween(10, 350),
            'goals' => fake()->numberBetween(0, 120),
            'assists' => fake()->numberBetween(0, 60),
            'clean_sheets' => fake()->numberBetween(0, 40),
            'honours' => [
                'League Champions' => '2024/25 Season',
                'National Cup Winner' => '2023/24 Season',
            ],
            'social_links' => [
                'Instagram' => 'https://instagram.com/'.Str::lower($this->slugPart()),
            ],
            'status' => 'published',
            'is_featured' => false,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    private function slugPart(): string
    {
        return (string) $this->faker->bothify('player_###');
    }
}
