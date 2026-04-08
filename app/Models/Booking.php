<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use PowerComponents\LivewirePowerGrid\Concerns\SoftDeletes;

#[Fillable(['property_id', 'check_in', 'check_out', 'status'])]
class Booking extends Model
{
    use BelongsToProperty, SoftDeletes;

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];
}
