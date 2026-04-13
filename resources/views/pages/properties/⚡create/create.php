<?php

use App\Models\Property;
use App\Models\User;
use Livewire\Component;

new class extends Component {
    public string $name = '';
    public string $subdomain = '';

    public array $address = [
        'line_1' => '',
        'line_2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'country' => '',
    ];

    public array $manager = [
        'add' => false,
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'subdomain' => 'required|string|unique:properties,subdomain',
            'manager.name' => 'required_if:manager.add,1|string',
            'manager.email' => 'required_if:manager.add,1|email|string',
            'manager.password' => 'required_if:manager.add,1|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $property = Property::create($data);

        $property->updateAddress($this->address);

        if ($this->manager['add']) {
            User::create($data['manager'] + [
                'property_id' => $property->id
            ])->assignRole('property-manager');
        }

        return to_route('dashboard');
    }
};
