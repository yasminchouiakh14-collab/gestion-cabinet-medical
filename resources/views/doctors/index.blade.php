@extends('layouts.app')

@section('title', __('navigation.doctors'))
@section('page-title', __('navigation.doctors'))

@section('content')
<div class="row g-4">
    @forelse($doctors as $doctor)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="bg-primary text-white p-3 text-center" style="height: 100px; background: linear-gradient(135deg, #1d4ed8, #3b82f6) !important;">
                <span class="badge bg-white text-primary position-absolute top-0 end-0 m-3 shadow-sm rounded-pill">{{ $doctor->appointments_count ?? 0 }} RDV</span>
            </div>
            <div class="text-center mt-n5 position-relative">
                <div class="avatar bg-white text-primary border border-4 border-white shadow-sm d-inline-flex align-items-center justify-content-center fw-bold fs-3 rounded-circle" style="width: 80px; height: 80px;">
                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                </div>
            </div>
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-1">Dr. {{ str_replace('Dr.', '', $doctor->name) }}</h5>
                <p class="text-muted small mb-3"><i class="bi bi-award me-1"></i>{{ $doctor->speciality ?? 'Généraliste' }}</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="mailto:{{ $doctor->email }}" class="btn btn-sm btn-light text-muted border tooltip-test" title="{{ $doctor->email }}"><i class="bi bi-envelope"></i></a>
                    <a href="tel:{{ $doctor->phone }}" class="btn btn-sm btn-light text-muted border tooltip-test" title="{{ $doctor->phone }}"><i class="bi bi-telephone"></i></a>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">Aucun médecin enregistré.</div>
    @endforelse
</div>
@endsection
