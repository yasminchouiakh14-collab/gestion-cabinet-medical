<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'service']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn($r) => $r->where('name', 'like', "%$search%"))
                  ->orWhereHas('doctor',  fn($r) => $r->where('name', 'like', "%$search%"))
                  ->orWhereHas('service', fn($r) => $r->where('name', 'like', "%$search%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = User::where('role', 'patient')->orderBy('name')->get();
        $doctors  = User::where('role', 'doctor')->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('appointments.create', compact('patients', 'doctors', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'doctor_id'        => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'status'           => 'required|in:pending,confirmed,cancelled,completed',
            'notes'            => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::create($validated);
        $appointment->load(['patient', 'doctor', 'service']);

        // Send confirmation email if status is confirmed
        if ($appointment->status === 'confirmed') {
            try {
                Mail::to($appointment->patient->email)
                    ->send(new AppointmentConfirmation($appointment));
            } catch (\Exception $e) {
                // Log silently, don't block the flow
                \Log::warning('Mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointments.index')
            ->with('success', __('messages.appointment_created'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'service']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = User::where('role', 'patient')->orderBy('name')->get();
        $doctors  = User::where('role', 'doctor')->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'doctor_id'        => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'status'           => 'required|in:pending,confirmed,cancelled,completed',
            'notes'            => 'nullable|string|max:500',
        ]);

        $wasNotConfirmed = $appointment->status !== 'confirmed';
        $appointment->update($validated);

        // Send mail on status change to confirmed
        if ($wasNotConfirmed && $appointment->status === 'confirmed') {
            $appointment->load(['patient', 'doctor', 'service']);
            try {
                Mail::to($appointment->patient->email)
                    ->send(new AppointmentConfirmation($appointment));
            } catch (\Exception $e) {
                \Log::warning('Mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointments.index')
            ->with('success', __('messages.appointment_updated'));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', __('messages.appointment_deleted'));
    }
}
