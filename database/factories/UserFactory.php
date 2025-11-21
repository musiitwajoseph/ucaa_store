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
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        
        return [
            'name' => $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            
            // Contact Information
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => 'USA',
            'postal_code' => fake()->postcode(),
            
            // Organization Information
            'department' => fake()->randomElement(['IT', 'HR', 'Sales', 'Marketing', 'Finance', 'Operations']),
            'job_title' => fake()->jobTitle(),
            'employee_id' => 'EMP' . fake()->unique()->numberBetween(1000, 9999),
            'office_location' => fake()->randomElement(['Main Office', 'Branch Office', 'Remote']),
            
            // Profile
            'bio' => fake()->sentence(20),
            'date_of_birth' => fake()->date('Y-m-d', '-25 years'),
            'gender' => fake()->randomElement(['male', 'female', 'other', 'prefer_not_to_say']),
            
            // Account Status
            'status' => 'active',
            'is_active' => true,
            'is_admin' => false,
            'is_ldap_user' => false,
            
            // Preferences
            'locale' => 'en',
            'timezone' => 'UTC',
            'theme' => 'light',
            
            'last_login_at' => fake()->dateTimeBetween('-30 days', 'now'),
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
