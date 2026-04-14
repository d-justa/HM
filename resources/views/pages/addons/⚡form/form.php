<?php

use App\Models\Addon;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public ?Addon $addon = null;

    public $property_id;
    public string $name = '';
    public $default_price;

    public function mount(?Addon $addon = null)
    {
        $this->property_id = 1;

        if ($addon && $addon->exists) {
            $this->fill($addon->toArray());
        }
    }

    protected function rules()
    {
        return [
            'property_id' => 'required',
            'name' => 'required|string',
            'default_price' => 'nullable|numeric',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $addon = Addon::updateOrCreate([
            'id' => $this->addon?->id
        ], $data);

        $this->reset();

        Flux::toast(
            heading: 'Changes saved',
            text: 'Your changes have been saved.',
            variant: 'success',
        );

        return $this->redirectRoute('addons.index', navigate: true);
    }
};
