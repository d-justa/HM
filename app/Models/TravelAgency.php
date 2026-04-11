<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use PowerComponents\LivewirePowerGrid\Concerns\SoftDeletes;

#[Fillable(['property_id', 'name', 'website', 'note'])]
class TravelAgency extends Model
{
    use BelongsToProperty, SoftDeletes;
}
