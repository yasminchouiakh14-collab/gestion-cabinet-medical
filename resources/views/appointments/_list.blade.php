@forelse($appointments as $apt)
    <tr>
        <td class="text-muted fw-semibold">#{{ $apt->id }}</td>
        <td>
            <div class="fw-semibold text-dark">{{ $apt->appointment_date->format('d M, Y') }}</div>
            <small class="text-muted">{{ $apt->appointment_date->format('H:i') }}</small>
        </td>
        <td>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar bg-light text-primary" style="width:24px;height:24px;font-size:0.65rem">
                    {{ strtoupper(substr($apt->patient->name, 0, 1)) }}
                </div>
                {{ $apt->patient->name }}
            </div>
        </td>
        <td><span class="text-muted">Dr.</span> {{ $apt->doctor->name }}</td>
        <td>{{ $apt->service->icon }} {{ $apt->service->name }}</td>
        <td>
            <span class="badge badge-status status-{{ $apt->status }}">
                {{ __('messages.'.$apt->status) }}
            </span>
        </td>
        <td class="text-end">
            <!-- Edit Button -->
            <a href="{{ route('appointments.edit', $apt) }}" class="btn btn-sm btn-light text-info mx-1" title="{{ __('navigation.edit') }}">
                <i class="bi bi-pencil"></i>
            </a>
            <!-- Delete Button triggers Modal -->
            <button type="button" class="btn btn-sm btn-light text-danger" title="{{ __('navigation.delete') }}" 
                    data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $apt->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-3 d-block mb-2 text-black-50"></i>
            {{ __('messages.no_appointments') }}
        </td>
    </tr>
@endforelse
