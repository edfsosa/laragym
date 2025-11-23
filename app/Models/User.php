<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'xp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'xp' => 'integer',
        ];
    }

    /**
     * Determina si el usuario puede acceder al panel de administración de Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * Relación con PersonalData, que almacena los datos personales del usuario
     */
    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

    /**
     * Relación con Address, que almacena la dirección del usuario
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Relación con UserMembership, que almacena las membresías del usuario
     */
    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Obtener la URL del avatar del usuario
     */
    public function getAvatarUrlAttribute(): string
    {
        if (! $this->personalData?->avatar) {
            return "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541";
        }

        return asset('storage/' . $this->personalData->avatar);
    }

    /**
     * Obtener el número de documento del usuario
     */
    public function getDocumentNumberAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->document_number : null;
    }

    /**
     * Obtener el género del usuario
     */
    public function getGenderAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->gender : null;
    }

    /**
     * Obtener el género del usuario traducido
     */
    public function getGenderTranslatedAttribute(): ?string
    {
        if (!$this->personalData) {
            return null;
        }

        switch ($this->personalData->gender) {
            case 'male':
                return __('Masculino');
            case 'female':
                return __('Femenino');
            default:
                return $this->personalData->gender;
        }
    }

    /**
     * Obtener la fecha de nacimiento del usuario en formato dd/mm/aaaa
     */
    public function getBirthDateAttribute(): ?string
    {
        return $this->personalData && $this->personalData->birth_date
            ? $this->personalData->birth_date->format('d/m/Y')
            : null;
    }

    /**
     * Obtener el teléfono del usuario
     */
    public function getPhoneAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->phone : null;
    }

    /**
     * Obtener la ciudad del usuario
     */
    public function getCityAttribute(): ?string
    {
        return $this->address ? $this->address->city->name : null;
    }

    /**
     * Obtener la calle del usuario
     */
    public function getStreetAttribute(): ?string
    {
        return $this->address ? $this->address->street : null;
    }

    /**
     * Obtener el número de la dirección del usuario
     */
    public function getNumberAttribute(): ?string
    {
        return $this->address ? $this->address->number : null;
    }

    /**
     * Obtener la referencia de la dirección del usuario
     */
    public function getReferenceAttribute(): ?string
    {
        return $this->address ? $this->address->reference : null;
    }

    /**
     * Obtener la dirección completa del usuario
     */
    public function getFullAddressAttribute(): ?string
    {
        if (!$this->address) {
            return null;
        }
        return "{$this->address->street} N° {$this->address->number}, {$this->address->city?->name}";
    }

    /**
     * Relación con UserRoutine
     */
    public function userRoutines()
    {
        return $this->hasMany(UserRoutine::class);
    }

    /**
     * Relación con UserRoutine para rutinas asignadas por el usuario
     */
    public function assignedRoutines()
    {
        return $this->hasMany(UserRoutine::class, 'assigned_by');
    }

    /**
     * Relación con BodyMetric, que almacena las métricas corporales del usuario
     */
    public function bodyMetrics()
    {
        return $this->hasMany(BodyMetric::class);
    }

    /**
     * Relación con BodyMetric para obtener la última métrica corporal del usuario
     */
    public function latestBodyMetric()
    {
        return $this->hasOne(BodyMetric::class)->latestOfMany('measurement_date');
    }

    /**
     * Relación con UserAchievement, que almacena los logros desbloqueados por el usuario
     */
    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }

    /**
     * Relación con Achievement a través de UserAchievement
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }

    /**
     * Obtener el nivel del usuario basado en su experiencia (xp)
     */
    public function getLevelAttribute()
    {
        return Level::getLevelByXp($this->xp);
    }

    /**
     * Obtener el estado del usuario traducido
     */
    public function getStatusTranslatedAttribute(): string
    {
        switch ($this->status) {
            case 'active':
                return __('Activo');
            case 'inactive':
                return __('Inactivo');
            case 'suspended':
                return __('Suspendido');
            default:
                return $this->status;
        }
    }

    public function getStatusBadgeClassAttribute(): string
    {
        switch ($this->status) {
            case 'active':
                return 'badge-success';
            case 'inactive':
                return 'badge-error';
            case 'suspended':
                return 'badge-warning';
            default:
                return 'badge-primary';
        }
    }
}
