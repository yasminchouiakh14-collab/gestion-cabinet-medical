<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Médecine Générale',  'description' => 'Consultation de médecine générale pour adultes et enfants.', 'duration_minutes' => 20, 'price' => 25.00, 'icon' => '🩺'],
            ['name' => 'Cardiologie',         'description' => 'Examens et suivi des maladies cardiovasculaires.', 'duration_minutes' => 45, 'price' => 60.00, 'icon' => '❤️'],
            ['name' => 'Pédiatrie',           'description' => 'Soins médicaux dédiés aux nourrissons, enfants et adolescents.', 'duration_minutes' => 30, 'price' => 35.00, 'icon' => '👶'],
            ['name' => 'Dermatologie',        'description' => 'Diagnostic et traitement des maladies de la peau.', 'duration_minutes' => 30, 'price' => 40.00, 'icon' => '🔬'],
            ['name' => 'Ophtalmologie',       'description' => 'Examens de la vue et traitement des maladies oculaires.', 'duration_minutes' => 40, 'price' => 45.00, 'icon' => '👁️'],
            ['name' => 'Neurologie',          'description' => 'Diagnostic et traitement des troubles du système nerveux.', 'duration_minutes' => 60, 'price' => 80.00, 'icon' => '🧠'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
