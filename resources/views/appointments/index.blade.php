@extends('layouts.app')

@section('title', __('navigation.appointments'))
@section('page-title', __('navigation.appointments'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Axios Search Bar -->
    <div class="position-relative w-100 max-w-md">
        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input type="text" id="searchInput" class="form-control form-control-lg border-0 shadow-sm rounded-pill ps-5 bg-white" placeholder="{{ __('messages.search_placeholder') }}">
    </div>
    
    <!-- Quick Add Button with Modal Trigger -->
    <button type="button" class="btn btn-primary rounded-pill shadow-sm px-4 ms-3 flex-shrink-0" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
        <i class="bi bi-plus-lg me-2"></i>{{ __('navigation.new_appointment') }}
    </button>
</div>

<div class="table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="appointmentsTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.patient') }}</th>
                    <th>{{ __('messages.doctor') }}</th>
                    <th>{{ __('messages.service') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th class="text-end">{{ __('navigation.actions') }}</th>
                </tr>
            </thead>
            <tbody id="appointmentsList">
                @include('appointments._list', ['appointments' => $appointments])
            </tbody>
        </table>
    </div>
    
    <div class="card-footer bg-white border-top p-3" id="paginationContainer">
        {{ $appointments->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal for Create Appointment (loaded via separate view to keep things clean or embedded here) -->
<div class="modal fade" id="createAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-plus text-primary me-2"></i>{{ __('navigation.new_appointment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Standard form submission for creation as requested, though API could be used -->
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('messages.patient') }}</label>
                            <select name="patient_id" class="form-select border-0 bg-light" required>
                                <option value="">Choisir un patient...</option>
                                @foreach(\App\Models\User::where('role', 'patient')->get() as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('messages.doctor') }}</label>
                            <select name="doctor_id" class="form-select border-0 bg-light" required>
                                <option value="">Choisir un médecin...</option>
                                @foreach(\App\Models\User::where('role', 'doctor')->get() as $d)
                                    <option value="{{ $d->id }}">Dr. {{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('messages.service') }}</label>
                            <select name="service_id" class="form-select border-0 bg-light" required>
                                <option value="">Choisir un service...</option>
                                @foreach(\App\Models\Service::all() as $s)
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
                                <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                <option value="completed">{{ __('messages.completed') }}</option>
                            </select>
                        </div>
                         <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('messages.notes') }}</label>
                            <textarea name="notes" class="form-control border-0 bg-light" rows="2" placeholder="Informations supplémentaires..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light rounded-bottom-3">
                    <button type="button" class="btn btn-secondary text-white border-0" data-bs-dismiss="modal">{{ __('navigation.cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>{{ __('navigation.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Deletion Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="display-3 text-danger mb-3"><i class="bi bi-exclamation-circle-fill"></i></div>
                <h5 class="fw-bold mb-3">{{ __('messages.confirm_delete') }}</h5>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">{{ __('navigation.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('navigation.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Delete Modal Logic
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        document.getElementById('deleteForm').action = `/appointments/${id}`;
    });

    // Axios Real-time Search
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const appointmentsList = document.getElementById('appointmentsList');
    const paginationContainer = document.getElementById('paginationContainer');

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        let q = this.value;
        
        searchTimeout = setTimeout(() => {
            if(q.length >= 2 || q.length === 0) {
                // Determine translation strings based on current locale
                const isFr = "{{ app()->getLocale() }}" === "fr";
                
                axios.get('/api/appointments/search', { params: { q: q } })
                    .then(response => {
                        // Hide standard pagination when searching
                        if(q.length > 0) paginationContainer.style.display = 'none';
                        else paginationContainer.style.display = 'block';

                        let html = '';
                        if(response.data.length === 0) {
                            html = `<tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-search d-block fs-3 mb-2"></i>{{ __('messages.no_appointments') }}</td></tr>`;
                        } else {
                            response.data.forEach(apt => {
                                // Format date nicely
                                let d = new Date(apt.appointment_date);
                                let dateStr = d.toLocaleDateString(isFr ? 'fr-FR' : 'en-US', {day:'2-digit', month:'short', year:'numeric'});
                                let timeStr = d.toLocaleTimeString(isFr ? 'fr-FR' : 'en-US', {hour:'2-digit', minute:'2-digit'});
                                
                                // Status mapping
                                let statusLabels = {
                                    pending: isFr ? 'En attente' : 'Pending',
                                    confirmed: isFr ? 'Confirmé' : 'Confirmed',
                                    cancelled: isFr ? 'Annulé' : 'Cancelled',
                                    completed: isFr ? 'Terminé' : 'Completed'
                                };
                                
                                html += `
                                <tr>
                                    <td class="text-muted fw-semibold">#${apt.id}</td>
                                    <td><div class="fw-semibold text-dark">${dateStr}</div><small class="text-muted">${timeStr}</small></td>
                                    <td><div class="d-flex align-items-center gap-2">
                                        <div class="avatar bg-light text-primary" style="width:24px;height:24px;font-size:0.65rem">${apt.patient.name.charAt(0)}</div>
                                        ${apt.patient.name}
                                    </div></td>
                                    <td><span class="text-muted">Dr.</span> ${apt.doctor.name}</td>
                                    <td>${apt.service.icon} ${apt.service.name}</td>
                                    <td><span class="badge badge-status status-${apt.status}">${statusLabels[apt.status]}</span></td>
                                    <td class="text-end">
                                        <a href="/appointments/${apt.id}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i></a>
                                        <a href="/appointments/${apt.id}/edit" class="btn btn-sm btn-light text-info mx-1"><i class="bi bi-pencil"></i></a>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="${apt.id}"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>`;
                            });
                        }
                        appointmentsList.innerHTML = html;
                    })
                    .catch(error => console.error('Search error:', error));
            }
        }, 300); // 300ms debounce
    });
</script>
<style>
    .max-w-md { max-width: 450px; }
    .form-control:focus { box-shadow: none; border-color: var(--primary); background: #f8fafc !important; }
</style>
@endpush
