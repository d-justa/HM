<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use PowerComponents\LivewirePowerGrid\Concerns\SoftDeletes;

#[Fillable(['property_id', 'name', 'default_price'])]
class Addon extends Model
{
    use BelongsToProperty, SoftDeletes;
}
