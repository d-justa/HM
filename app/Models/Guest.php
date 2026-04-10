<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['property_id', 'first_name', 'last_name', 'email', 'phone', 'internal_notes'])]
class Guest extends Model
{
    use BelongsToProperty, SoftDeletes;

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
