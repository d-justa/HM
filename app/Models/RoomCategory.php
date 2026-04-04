<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable('property_id', 'name', 'description')]
class RoomCategory extends Model
{
    use BelongsToProperty, SoftDeletes;
}
