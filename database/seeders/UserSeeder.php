<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@cabinet-medical.fr',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '0600000000',
        ]);

        // Médecins
        $doctors = [
            ['name' => 'Dr. Ahmed Benali',   'email' => 'dr.benali@cabinet-medical.fr',   'speciality' => 'Cardiologie'],
            ['name' => 'Dr. Sofia Mourad',   'email' => 'dr.mourad@cabinet-medical.fr',   'speciality' => 'Pédiatrie'],
            ['name' => 'Dr. Karim Lahlou',   'email' => 'dr.lahlou@cabinet-medical.fr',   'speciality' => 'Médecine Générale'],
        ];

        foreach ($doctors as $doc) {
            User::create([
                'name'       => $doc['name'],
                'email'      => $doc['email'],
                'password'   => Hash::make('password'),
                'role'       => 'doctor',
                'speciality' => $doc['speciality'],
                'phone'      => '06' . rand(10000000, 99999999),
            ]);
        }

        // Patients (10)
        $patients = [
            ['name' => 'Marie Dupont',      'email' => 'marie.dupont@email.fr'],
            ['name' => 'Jean-Pierre Martin','email' => 'jp.martin@email.fr'],
            ['name' => 'Fatima Zahra',      'email' => 'fatima.zahra@email.fr'],
            ['name' => 'Lucas Bernard',     'email' => 'lucas.bernard@email.fr'],
            ['name' => 'Isabelle Leroy',    'email' => 'isabelle.leroy@email.fr'],
            ['name' => 'Youssef Tazi',      'email' => 'youssef.tazi@email.fr'],
            ['name' => 'Chloé Dubois',      'email' => 'chloe.dubois@email.fr'],
            ['name' => 'Marc Fontaine',     'email' => 'marc.fontaine@email.fr'],
            ['name' => 'Nadia Hamidi',      'email' => 'nadia.hamidi@email.fr'],
            ['name' => 'Thomas Moreau',     'email' => 'thomas.moreau@email.fr'],
        ];

        foreach ($patients as $patient) {
            User::create([
                'name'     => $patient['name'],
                'email'    => $patient['email'],
                'password' => Hash::make('password'),
                'role'     => 'patient',
                'phone'    => '06' . rand(10000000, 99999999),
            ]);
        }
    }
}
