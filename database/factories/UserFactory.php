<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // Required custom fields per users table schema
            // Use unique values to satisfy unique index constraints
            'join_date' => fake()->unique()->date('Y-m-d'),
            'last_login' => fake()->unique()->dateTimeBetween('-30 days', 'now')->format('Y-m-d H:i:s'),
            'phone_number' => fake()->optional()->phoneNumber(),
            'status' => fake()->optional()->randomElement(['Active', 'Inactive']),
            'role_name' => fake()->optional()->randomElement(['Admin', 'HR', 'Employee']),
            'avatar' => null,
            'position' => fake()->optional()->jobTitle(),
            'department' => fake()->optional()->randomElement(['HR', 'Finance', 'Engineering', 'Sales']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
