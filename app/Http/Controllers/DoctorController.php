<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index()
    {
        $doctors = User::where('role', 'doctor')
            ->withCount(['appointmentsAsDoctor as appointments_count'])
            ->orderBy('name')
            ->get();

        return view('doctors.index', compact('doctors'));
    }

    public function show(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        $appointments = $doctor->appointmentsAsDoctor()
            ->with(['patient', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('doctors.show', compact('doctor', 'appointments'));
    }
}
