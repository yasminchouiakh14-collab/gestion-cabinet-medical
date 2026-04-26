@extends('layouts.patient')

@section('title', 'Accueil Patient')
@section('page-title', 'Accueil Patient')

@section('content')
<div class="row g-4">
    <!-- Welcome Header -->
    <div class="col-12">
        <div class="patient-card bg-primary text-white p-4 p-md-5 position-relative overflow-hidden">
            <!-- decorative circles -->
            <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 200px; height: 200px; top: -50px; right: -50px;"></div>
            <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 150px; height: 150px; bottom: -30px; right: 100px;"></div>
            
            <div class="position-relative z-1">
                <h2 class="fw-bold mb-2">Bonjour, {{ auth()->user()->name }}</h2>
                <p class="mb-4 fs-5 text-white-50">Bienvenue dans votre espace santé. Que souhaitez-vous faire aujourd'hui ?</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('appointments.create') }}" class="btn btn-light text-primary btn-lg fw-bold rounded-pill shadow-sm px-4">
                        <i class="bi bi-calendar-plus me-2"></i>Prendre un rendez-vous
                    </a>
                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="bi bi-clock-history me-2"></i>Mon historique
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="col-12">
        <div class="patient-card p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-calendar-event text-primary me-2"></i>Mes prochains rendez-vous</h5>
            
            @if($upcomingAppointments->count() > 0)
                <div class="row g-3">
                    @foreach($upcomingAppointments as $apt)
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded-4 p-3 h-100 position-relative transition-all hover-shadow">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="badge badge-status status-{{ $apt->status }} mb-2">
                                        {{ __('messages.'.$apt->status) }}
                                    </div>
                                    <a href="{{ route('appointments.show', $apt) }}" class="btn btn-sm btn-light rounded-circle text-primary"><i class="bi bi-arrow-right"></i></a>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">{{ $apt->appointment_date->format('d M Y') }}</h4>
                                <div class="text-primary fw-semibold mb-3"><i class="bi bi-clock me-1"></i>{{ $apt->appointment_date->format('H:i') }}</div>
                                
                                <div class="p-2 bg-light rounded-3 d-flex align-items-center gap-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm text-primary" style="width:40px;height:40px;font-size:1.2rem;">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark fs-6 w-100 text-truncate" style="max-width:150px">Dr. {{ $apt->doctor->name }}</div>
                                        <div class="text-muted small w-100 text-truncate" style="max-width:150px">{{ $apt->service->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 bg-light rounded-4">
                    <div class="display-3 text-muted mb-4"><i class="bi bi-calendar2-x"></i></div>
                    <h5 class="text-dark fw-bold">Aucun rendez-vous prévu</h5>
                    <p class="text-muted mb-4">Vous n'avez pas de consultations médicales à venir.</p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary rounded-pill px-4">Programmer une consultation</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow { transition: all 0.2s; }
    .hover-shadow:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); transform: translateY(-3px); border-color: var(--primary) !important; }
</style>
@endsection
