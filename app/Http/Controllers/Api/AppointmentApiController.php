<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    /**
     * GET /api/appointments — liste paginée JSON
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient:id,name,email', 'doctor:id,name,speciality', 'service:id,name,price']);

        if (auth('web')->check() && auth('web')->user()->isPatient()) {
            $query->where('patient_id', auth('web')->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(15);

        return response()->json($appointments);
    }

    /**
     * GET /api/appointments/{id}
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient:id,name,email,phone', 'doctor:id,name,speciality', 'service']);
        return response()->json($appointment);
    }

    /**
     * POST /api/appointments — créer un RDV via requête externe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'doctor_id'        => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes'            => 'nullable|string|max:500',
        ]);

        $validated['status'] = 'pending';
        $appointment = Appointment::create($validated);
        $appointment->load(['patient', 'doctor', 'service']);

        return response()->json([
            'message'     => 'Rendez-vous créé avec succès.',
            'appointment' => $appointment,
        ], 201);
    }

    /**
     * GET /api/appointments/search?q=...  — recherche Axios
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $status = $request->input('status', '');
        $date = $request->input('date', '');

        $query = Appointment::with(['patient:id,name', 'doctor:id,name,speciality', 'service:id,name,icon']);

        if (auth('web')->check() && auth('web')->user()->isPatient()) {
            $query->where('patient_id', auth('web')->id());
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('patient', fn($r) => $r->where('name', 'like', "%$q%"))
                    ->orWhereHas('doctor',  fn($r) => $r->where('name', 'like', "%$q%"))
                    ->orWhereHas('service', fn($r) => $r->where('name', 'like', "%$q%"));
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($date) {
            $query->whereDate('appointment_date', $date);
        }

        $results = $query->orderBy('appointment_date', 'desc')->limit(20)->get();

        return response()->json($results);
    }

    /**
     * GET /api/doctors
     */
    public function doctors()
    {
        $doctors = User::where('role', 'doctor')
            ->select('id', 'name', 'speciality', 'phone')
            ->get();

        return response()->json($doctors);
    }
}
