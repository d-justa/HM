<?php

use App\Models\TravelAgency;
use Livewire\Component;

new class extends Component
{
    public ?TravelAgency $travelAgency = null;

    public $property_id;
    public string $name = '';
    public string $website = '';
    public string $note = '';

    public array $address = [
        'line_1' => '',
        'line_2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'country' => '',
    ];

    public function mount(?TravelAgency $travelAgency = null)
    {
        $this->property_id = 1;
        
        if ($travelAgency && $travelAgency->exists) {
            $this->fill($travelAgency->toArray());
            $this->address = $travelAgency->address->toArray();
        }
    }

    protected function rules()
    {
        return [
            'property_id' => 'required',
            'name' => 'required|string',
            'website' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $travelAgency = TravelAgency::updateOrCreate([
            'id' => $this->travelAgency?->id
        ], $data);

        $travelAgency->updateAddress($this->address);

        $this->reset();

        return to_route('travel-agencies.index');
    }
};
