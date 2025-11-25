<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    /**
     * Obtener el usuario asociado a esta membresía de usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la membresía asociada a esta membresía de usuario.
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    /**
     * Obtener el nombre del usuario asociado.
     */
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    /**
     * Obtener el nombre de la membresía asociada.
     */
    public function getMembershipNameAttribute()
    {
        return $this->membership ? $this->membership->name : null;
    }

    /**
     * Obtener la descripción de la membresía asociada.
     */
    public function getMembershipDescriptionAttribute()
    {
        return $this->membership ? $this->membership->description : null;
    }

    /**
     * Obtener el precio de la membresía asociada en formato guaraníes paraguayos.
     */
    public function getMembershipPriceAttribute()
    {
        return $this->membership ? 'Gs. ' . number_format($this->membership->price, 0, ',', '.') : null;
    }

    /**
     * Obtener las fechas de inicio y fin en formato 'd/m/Y'.
     */
    public function getStartAtFormattedAttribute()
    {
        return $this->start_at ? $this->start_at->format('d/m/Y') : null;
    }

    public function getEndAtFormattedAttribute()
    {
        return $this->end_at ? $this->end_at->format('d/m/Y') : null;
    }

    /**
     * Obtener los pagos asociados a esta membresía de usuario.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_membership_id');
    }

    /**
     * Obtener la etiqueta de estado legible.
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'active':
                return __('Active');
            case 'expired':
                return __('Expired');
            case 'cancelled':
                return __('Cancelled');
            default:
                return __('Unknown');
        }
    }

    /**
     * Verificar si la membresía está por vencer en los próximos 7 días.
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->end_at) {
            return false;
        }

        $now = now();
        $daysUntilEnd = $now->diffInDays($this->end_at, false);

        return $daysUntilEnd >= 0 && $daysUntilEnd <= 7;
    }

    public function getDurationAttribute()
    {
        if (!$this->start_at || !$this->end_at) {
            return null;
        }

        $interval = $this->start_at->diff($this->end_at);

        $parts = [];
        if ($interval->y > 0) {
            $parts[] = $interval->y . ' ' . __('year(s)');
        }
        if ($interval->m > 0) {
            $parts[] = $interval->m . ' ' . __('month(s)');
        }
        if ($interval->d > 0) {
            $parts[] = $interval->d . ' ' . __('day(s)');
        }

        return implode(', ', $parts);
    }
}
