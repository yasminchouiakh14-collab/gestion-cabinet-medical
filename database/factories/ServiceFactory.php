<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $services = [
            ['name' => 'Médecine Générale',  'icon' => '🩺', 'duration' => 20, 'price' => 25.00],
            ['name' => 'Cardiologie',         'icon' => '❤️', 'duration' => 45, 'price' => 60.00],
            ['name' => 'Pédiatrie',           'icon' => '👶', 'duration' => 30, 'price' => 35.00],
            ['name' => 'Dermatologie',        'icon' => '🔬', 'duration' => 30, 'price' => 40.00],
            ['name' => 'Ophtalmologie',       'icon' => '👁️',  'duration' => 40, 'price' => 45.00],
            ['name' => 'Neurologie',          'icon' => '🧠', 'duration' => 60, 'price' => 80.00],
        ];

        $service = fake()->randomElement($services);

        return [
            'name'             => $service['name'],
            'description'      => fake()->sentence(10),
            'duration_minutes' => $service['duration'],
            'price'            => $service['price'],
            'icon'             => $service['icon'],
            'is_active'        => true,
        ];
    }
}
