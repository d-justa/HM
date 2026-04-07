<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'subdomain'])]
class Property extends Model
{
    public function roomCategories(): HasMany
    {
        return $this->hasMany(RoomCategory::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
