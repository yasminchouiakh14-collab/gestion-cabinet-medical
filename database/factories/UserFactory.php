<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'            => fake()->name(),
            'email'           => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'        => Hash::make('password'),
            'role'            => 'patient',
            'phone'           => fake()->phoneNumber(),
            'date_of_birth'   => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'speciality'      => null,
            'avatar'          => null,
            'remember_token'  => \Illuminate\Support\Str::random(10),
        ];
    }

    public function doctor(): static
    {
        $specialities = [
            'Cardiologie', 'Pédiatrie', 'Médecine Générale',
            'Dermatologie', 'Ophtalmologie', 'Neurologie',
        ];

        return $this->state(fn (array $attributes) => [
            'role'       => 'doctor',
            'speciality' => fake()->randomElement($specialities),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'name' => 'Administrateur',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
