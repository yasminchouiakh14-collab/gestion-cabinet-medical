@extends('layouts.app')

@section('title', __('navigation.services'))
@section('page-title', __('navigation.services'))

@section('content')
<div class="row g-4">
    @forelse($services as $service)
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
            <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3 gap-3">
                    <div class="display-5" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">{{ $service->icon }}</div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $service->name }}</h5>
                        <span class="badge bg-light text-dark fw-normal border"><i class="bi bi-clock me-1"></i>{{ $service->duration_minutes }} min</span>
                        <span class="badge bg-light text-success fw-bold border ms-1">{{ number_format($service->price, 2) }} €</span>
                    </div>
                </div>
                <p class="text-muted small mb-3 text-truncate-2">{{ $service->description }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                     <small class="text-muted fw-semibold">Consultations: {{ $service->appointments_count ?? 0 }}</small>
                     <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }} bg-opacity-10 text-{{ $service->is_active ? 'success' : 'danger' }} border-0">{{ $service->is_active ? 'Actif' : 'Inactif' }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">Aucun service défini.</div>
    @endforelse
</div>
<style>
    .transition-hover { transition: transform 0.2s, box-shadow 0.2s; }
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.06) !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection
