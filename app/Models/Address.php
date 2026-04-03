<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'addressable_id',
    'addressable_type',
    'line_1',
    'line_2',
    'city',
    'state',
    'country',
    'type'
])]
class Address extends Model
{
    /**
     * Get the parent addressable model (user, store, etc.).
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
