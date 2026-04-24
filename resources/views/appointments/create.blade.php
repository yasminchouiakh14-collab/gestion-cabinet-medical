@extends('layouts.app')

@section('title', __('navigation.new_appointment'))
@section('page-title', __('navigation.new_appointment'))

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.patient') }}</label>
                    <select name="patient_id" class="form-select border-0 bg-light" required>
                        <option value="">Choisir un patient...</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.doctor') }}</label>
                    <select name="doctor_id" class="form-select border-0 bg-light" required>
                        <option value="">Choisir un médecin...</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}">Dr. {{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.service') }}</label>
                    <select name="service_id" class="form-select border-0 bg-light" required>
                        <option value="">Choisir un service...</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.date') }}</label>
                    <input type="datetime-local" name="appointment_date" class="form-control border-0 bg-light" required min="{{ date('Y-m-d\TH:i') }}">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select border-0 bg-light" required>
                        <option value="pending">{{ __('messages.pending') }}</option>
                        <option value="confirmed">{{ __('messages.confirmed') }}</option>
                        <option value="completed">{{ __('messages.completed') }}</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <label class="form-label fw-semibold">{{ __('messages.notes') }}</label>
                    <textarea name="notes" class="form-control border-0 bg-light" rows="4" placeholder="Informations supplémentaires..."></textarea>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                <a href="{{ route('appointments.index') }}" class="btn btn-light px-4">{{ __('navigation.cancel') }}</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>{{ __('navigation.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
