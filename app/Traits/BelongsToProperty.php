<?php

namespace App\Traits;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToProperty
{
    protected static function bootBelongsToProperty()
    {
        static::addGlobalScope('property', function (Builder $builder) {
            if (app()->bound('currentProperty')) {
                $builder->where('property_id', app('currentProperty')->id);
            }
        });

        static::creating(function ($model) {
            if (app()->bound('currentProperty')) {
                $model->property_id = app('currentProperty')->id;
            }
        });
    }

    /**
     * Get the property that owns the BelongsToProperty
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
