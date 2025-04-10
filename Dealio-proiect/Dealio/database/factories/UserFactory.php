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
        $createdAt = fake()->dateTimeBetween('2023-01-01', 'now');

        return [
            'user_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'full_name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'role' => fake()->randomElement(['admin', 'user', 'seller']),
            'address' => fake()->address(),
            'profile_photo_path' => fake()->imageUrl(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function seller(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'seller',
        ]);
    }

    public function regularUser(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'user',
        ]);
    }
}
