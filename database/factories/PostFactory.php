<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all()->pluck('id')->toArray();

        if (!count($userIds)) {
            return [];
        }

        return [
            'title' => fake()->jobTitle(),
            'content' => fake()->text(),
            'user_id' => (int)array_rand($userIds)
        ];
    }
}
