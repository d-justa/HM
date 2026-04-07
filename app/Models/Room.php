<?php

namespace App\Models;

use App\Traits\BelongsToProperty;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['property_id', 'room_category_id', 'name'])]
class Room extends Model
{
    use BelongsToProperty;

    public function roomCategory(): BelongsTo
    {
        return $this->belongsTo(RoomCategory::class);
    }
}
