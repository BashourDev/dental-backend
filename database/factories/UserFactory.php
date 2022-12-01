<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'plan_id' =>fake()->numberBetween(1, 3),
            'en_name' => fake()->name(),
            'en_country' => fake()->country(),
            'en_city' => fake()->city(),
            'en_address' => fake()->address(),
            'en_bio' => fake()->text(),
            'ar_name' => fake()->name(),
            'ar_country' => fake()->country(),
            'ar_city' => fake()->city(),
            'ar_address' => fake()->address(),
            'ar_bio' => fake()->text(),
            'phone' => fake()->phoneNumber(),
            'subscription_deadline' => now()->addMonths(10),
            'featured' => false,
            'type' => fake()->numberBetween(0, 1),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
