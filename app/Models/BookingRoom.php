<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Table(incrementing: true)]
#[Fillable(['booking_id', 'room_id', 'from_date', 'to_date'])]
class BookingRoom extends Pivot
{
    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];
}
