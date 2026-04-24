@extends('layouts.app')

@section('title', __('navigation.dashboard'))
@section('page-title', __('navigation.dashboard'))

@section('content')
    <div class="alert alert-info border-0 rounded-4 mb-4 shadow-sm">
        <div class="d-flex align-items-center gap-3 py-2">
            <div class="display-6 text-primary">👋</div>
            <div>
                <h4 class="mb-1 text-dark fw-bold">Bonjour {{ auth()->user()->name }} !</h4>
                <p class="mb-0 text-muted">{{ __('messages.welcome') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <!-- Stat Card 1 -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-1">{{ __('messages.total_appointments') }}</div>
                        <div class="stat-value">{{ $stats['total_appointments'] }}</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-1">{{ __('messages.pending') }}</div>
                        <div class="stat-value">{{ $stats['pending_appointments'] }}</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-1">{{ __('navigation.patients') }}</div>
                        <div class="stat-value">{{ $stats['total_patients'] }}</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-1">{{ __('navigation.doctors') }}</div>
                        <div class="stat-value">{{ $stats['total_doctors'] }}</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-person-badge"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row g-4">
        <!-- Upcoming Appointments -->
        <div class="col-xl-8">
            <div class="table-card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i>{{ __('messages.upcoming') }}</h5>
                    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">{{ __('navigation.view') }}</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.patient') }}</th>
                                    <th>{{ __('messages.doctor') }}</th>
                                    <th>{{ __('messages.service') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingAppointments as $apt)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $apt->appointment_date->format('d M, Y') }}</div>
                                            <small class="text-muted">{{ $apt->appointment_date->format('H:i') }}</small>
                                        </td>
                                        <td>{{ $apt->patient->name }}</td>
                                        <td><span class="text-muted">Dr.</span> {{ $apt->doctor->name }}</td>
                                        <td>{{ $apt->service->icon }} {{ $apt->service->name }}</td>
                                        <td>
                                            <span class="badge badge-status status-{{ $apt->status }}">
                                                {{ __('messages.'.$apt->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-calendar-x fs-4 d-block mb-2"></i>
                                            {{ __('messages.no_appointments') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Appointments (or empty column) -->
        <div class="col-xl-4">
             <div class="table-card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>{{ __('messages.recent') }}</h5>
                </div>
                <div class="card-body p-3">
                     <div class="d-flex flex-column gap-3">
                        @forelse($recentAppointments as $apt)
                            <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg-light transition-all border border-light">
                                <div class="avatar bg-light text-primary">
                                    {{ strtoupper(substr($apt->patient->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold">{{ $apt->patient->name }}</h6>
                                    <small class="text-muted">{{ $apt->service->name }} • {{ $apt->appointment_date->format('d/m/Y') }}</small>
                                </div>
                                <div>
                                    <span class="badge badge-status status-{{ $apt->status }} rounded-pill" style="font-size: 0.6rem; padding: 0.2rem 0.5rem;">
                                         {{ __('messages.'.$apt->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                             <div class="text-center py-4 text-muted">
                                 <small>{{ __('messages.no_appointments') }}</small>
                             </div>
                        @endforelse
                    </div>
                </div>
             </div>
        </div>
    </div>
@endsection
