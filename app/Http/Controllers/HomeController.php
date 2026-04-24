<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_appointments'   => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'total_patients'       => User::where('role', 'patient')->count(),
            'total_doctors'        => User::where('role', 'doctor')->count(),
            'total_services'       => Service::count(),
        ];

        $upcomingAppointments = Appointment::with(['patient', 'doctor', 'service'])
            ->where('appointment_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        $recentAppointments = Appointment::with(['patient', 'doctor', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'upcomingAppointments', 'recentAppointments'));
    }
}
