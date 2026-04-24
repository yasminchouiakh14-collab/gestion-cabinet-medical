<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
        'date_of_birth', 'speciality', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    // Scopes
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDoctor(): bool { return $this->role === 'doctor'; }
    public function isPatient(): bool { return $this->role === 'patient'; }

    // Relations
    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}
