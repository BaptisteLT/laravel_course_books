<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' =>  fake()->dateTimeBetween('created_at', 'now'),
            'title' => fake()->text(40),
            'author' => fake()->firstName(). ' '. fake()->lastName()
        ];
    }
}
