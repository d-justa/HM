<?php

namespace App\Traits;

use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;

trait PowerGridActions
{
    public function propertyName()
    {
        return Column::make('Property', 'property.name')
            ->hidden(app()->bound('currentProperty'));
    }

    public function addNewButton(string $routeName)
    {
        return Button::add('add-new')
            ->slot('Add New')
            ->class('pg-btn-white')
            ->route($routeName, []);
    }
}
