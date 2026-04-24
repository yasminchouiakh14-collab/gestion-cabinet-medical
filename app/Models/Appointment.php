<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'service_id',
        'appointment_date', 'status', 'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    // Status helpers
    public function isPending(): bool { return $this->status === 'pending'; }
    public function isConfirmed(): bool { return $this->status === 'confirmed'; }
    public function isCancelled(): bool { return $this->status === 'cancelled'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending'   => 'badge-warning',
            'confirmed' => 'badge-success',
            'cancelled' => 'badge-danger',
            'completed' => 'badge-secondary',
            default     => 'badge-light',
        };
    }

    // Relations
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
