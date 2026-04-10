<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PowerComponents\LivewirePowerGrid\Concerns\SoftDeletes;

#[Fillable(['property_id', 'guest_id', 'check_in', 'check_out', 'status'])]
class Booking extends Model
{
    use BelongsToProperty, SoftDeletes;

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class)->withTrashed();
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->using(BookingRoom::class)
            ->withPivot(['from_date', 'to_date']);
    }
}
