<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['property_id', 'room_category_id', 'name'])]
class Room extends Model
{
    use BelongsToProperty;

    public function roomCategory(): BelongsTo
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class)
            ->using(BookingRoom::class)
            ->withPivot(['from_date', 'to_date']);
    }
}
