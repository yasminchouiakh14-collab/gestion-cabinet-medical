@extends('layouts.app')

@section('title', __('navigation.edit') . ' ' . __('navigation.appointments'))
@section('page-title', __('navigation.edit') . ' RDV #' . $appointment->id)

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.patient') }}</label>
                    <select name="patient_id" class="form-select border-0 bg-light" required>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ $appointment->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.doctor') }}</label>
                    <select name="doctor_id" class="form-select border-0 bg-light" required>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" {{ $appointment->doctor_id == $d->id ? 'selected' : '' }}>Dr. {{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.service') }}</label>
                    <select name="service_id" class="form-select border-0 bg-light" required>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ $appointment->service_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.date') }}</label>
                    <input type="datetime-local" name="appointment_date" class="form-control border-0 bg-light" value="{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select border-0 bg-light" required>
                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                        <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>{{ __('messages.confirmed') }}</option>
                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                        <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <label class="form-label fw-semibold">{{ __('messages.notes') }}</label>
                    <textarea name="notes" class="form-control border-0 bg-light" rows="4">{{ $appointment->notes }}</textarea>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                <a href="{{ route('appointments.index') }}" class="btn btn-light px-4">{{ __('navigation.cancel') }}</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2 me-2"></i>{{ __('navigation.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
