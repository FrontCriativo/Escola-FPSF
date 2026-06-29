<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'is_admin',
    'phone',
    'enrollment_number',
    'class_name',
    'enrollment_status',
    'enrollment_started_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    protected static function booted(): void
    {
        static::deleting(function (User $user): void {
            $user->loans()->get()->each->delete();
        });
    }

    public static function enrollmentStatusOptions(): array
    {
        return [
            'active' => 'Matriculado',
            'inactive' => 'Inativo',
            'transferred' => 'Transferido',
            'graduated' => 'Concluido',
        ];
    }

    public function scopeStudents(Builder $query): Builder
    {
        return $query->where('is_admin', false);
    }

    public function scopeEnrolled(Builder $query): Builder
    {
        return $query->students()->where('enrollment_status', 'active');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function activeSessions(): HasMany
    {
        return $this->hasMany(ActiveSession::class);
    }

    public function sentEmails(): HasMany
    {
        return $this->hasMany(EmailLog::class, 'sender_id');
    }

    public function receivedEmails(): HasMany
    {
        return $this->hasMany(EmailLog::class, 'recipient_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'enrollment_started_at' => 'date',
        ];
    }
}
