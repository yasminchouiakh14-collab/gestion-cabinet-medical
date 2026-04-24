<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        // Mix of past and future appointments
        $date = fake()->randomElement([
            fake()->dateTimeBetween('-2 months', 'now'),
            fake()->dateTimeBetween('now', '+2 months'),
        ]);

        return [
            'patient_id'       => User::where('role', 'patient')->inRandomOrder()->first()?->id ?? 1,
            'doctor_id'        => User::where('role', 'doctor')->inRandomOrder()->first()?->id ?? 2,
            'service_id'       => Service::inRandomOrder()->first()?->id ?? 1,
            'appointment_date' => $date,
            'status'           => fake()->randomElement($statuses),
            'notes'            => fake()->optional(0.5)->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function confirmed(): static
    {
        return $this->state(['status' => 'confirmed']);
    }
}
