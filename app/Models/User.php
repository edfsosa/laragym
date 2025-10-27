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
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('Admin');
    }

    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->personalData ? $this->personalData->avatar : "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541";
    }

    public function getDocumentNumberAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->document_number : null;
    }

    public function getGenderAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->gender : null;
    }

    public function getBirthDateAttribute(): ?string // dd/mm/yyyy
    {
        return $this->personalData && $this->personalData->birth_date ? $this->personalData->birth_date->format('d/m/Y') : null;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->personalData ? $this->personalData->phone : null;
    }

    public function getCityAttribute(): ?string
    {
        return $this->address ? $this->address->city->name : null;
    }

    public function getStreetAttribute(): ?string
    {
        return $this->address ? $this->address->street : null;
    }

    public function getNumberAttribute(): ?string
    {
        return $this->address ? $this->address->number : null;
    }

    public function getReferenceAttribute(): ?string
    {
        return $this->address ? $this->address->reference : null;
    }

    public function getFullAddressAttribute(): ?string
    {
        if (!$this->address && !$this->address->city) {
            return null;
        } else {
            return "{$this->address->street} N° {$this->address->number}, {$this->address->city->name}";
        }
    }

    /**
     * Relación con UserRoutine
     */
    public function userRoutines()
    {
        return $this->hasMany(UserRoutine::class);
    }

    public function assignedRoutines()
    {
        return $this->hasMany(UserRoutine::class, 'assigned_by');
    }
}
