<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1,5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => fake()->dateTimeBetween('created_at', 'now'),
            'book_id' => null
        ];
    }

    public function good()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(4, 5)
            ];
        });
    }

    public function average()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(2, 5)
            ];
        });
    }

    public function bad()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(1, 3)
            ];
        });
    }
}
