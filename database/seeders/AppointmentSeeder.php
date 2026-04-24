<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::where('role', 'patient')->get();
        $doctors  = User::where('role', 'doctor')->get();
        $services = Service::all();
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        $appointments = [
            // Past appointments
            ['days' => -30, 'status' => 'completed'],
            ['days' => -25, 'status' => 'completed'],
            ['days' => -20, 'status' => 'completed'],
            ['days' => -18, 'status' => 'cancelled'],
            ['days' => -15, 'status' => 'completed'],
            ['days' => -12, 'status' => 'confirmed'],
            ['days' => -10, 'status' => 'completed'],
            ['days' => -7,  'status' => 'cancelled'],
            ['days' => -5,  'status' => 'completed'],
            ['days' => -3,  'status' => 'confirmed'],
            ['days' => -2,  'status' => 'pending'],
            ['days' => -1,  'status' => 'confirmed'],
            // Future appointments
            ['days' => 1,   'status' => 'confirmed'],
            ['days' => 2,   'status' => 'pending'],
            ['days' => 3,   'status' => 'confirmed'],
            ['days' => 5,   'status' => 'pending'],
            ['days' => 7,   'status' => 'confirmed'],
            ['days' => 10,  'status' => 'pending'],
            ['days' => 14,  'status' => 'pending'],
            ['days' => 15,  'status' => 'confirmed'],
            ['days' => 20,  'status' => 'pending'],
            ['days' => 25,  'status' => 'pending'],
            ['days' => 30,  'status' => 'pending'],
            ['days' => 35,  'status' => 'confirmed'],
            ['days' => 45,  'status' => 'pending'],
        ];

        $hours = [9, 10, 11, 14, 15, 16, 17];

        foreach ($appointments as $appt) {
            Appointment::create([
                'patient_id'       => $patients->random()->id,
                'doctor_id'        => $doctors->random()->id,
                'service_id'       => $services->random()->id,
                'appointment_date' => Carbon::now()
                    ->addDays($appt['days'])
                    ->setHour(collect($hours)->random())
                    ->setMinute(collect([0, 30])->random())
                    ->setSecond(0),
                'status'           => $appt['status'],
                'notes'            => rand(0, 1) ? 'Patient régulier, suivi périodique.' : null,
            ]);
        }
    }
}
