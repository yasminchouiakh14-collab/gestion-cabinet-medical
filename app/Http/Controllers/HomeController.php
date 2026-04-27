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
        $user = auth()->user();
        
        $baseQuery = Appointment::query();
        if ($user->isPatient()) {
            $baseQuery->where('patient_id', $user->id);
        }

        $stats = [
            'total_appointments'   => (clone $baseQuery)->count(),
            'pending_appointments' => (clone $baseQuery)->where('status', 'pending')->count(),
            'confirmed_appointments' => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'total_patients'       => User::where('role', 'patient')->count(),
            'total_doctors'        => User::where('role', 'doctor')->count(),
            'total_services'       => Service::count(),
        ];

        $upcomingAppointments = (clone $baseQuery)->with(['patient', 'doctor', 'service'])
            ->where('appointment_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        $recentAppointments = (clone $baseQuery)->with(['patient', 'doctor', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if ($user->isPatient()) {
            return view('patient-dashboard', compact('stats', 'upcomingAppointments', 'recentAppointments'));
        }

        return view('dashboard', compact('stats', 'upcomingAppointments', 'recentAppointments'));
    }
}
