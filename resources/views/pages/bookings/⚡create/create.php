<?php

use App\Models\Booking;
use App\Models\Guest;
use Livewire\Component;

new class extends Component
{
    public $property_id;

    public array $guest = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
    ];

    public $check_in;
    public $check_out;

    public function mount()
    {
        $this->property_id = 1;
    }

    protected function rules()
    {
        return [
            'property_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'guest.first_name' => 'required|string',
            'guest.last_name' => 'nullable|string',
            'guest.email' => 'nullable|string',
            'guest.phone' => 'nullable|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $guest = Guest::create($data['guest'] + [
            'property_id' => $this->property_id
        ]);

        $booking = Booking::create($data + [
            'guest_id' => $guest->id
        ]);

        return to_route('bookings.index');
    }
};
