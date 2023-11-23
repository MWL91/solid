<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function canReserve(): bool
    {
        return $this->reservations()->count() < $this->capacity;
    }
}
