<?php

use App\Enums\Enums\BookingSource;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Property;
use App\Models\TravelAgency;
use Flux\Flux;
use Livewire\Attributes\Computed;
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
    public array $selectedRooms = []; // Stores room_id => [from, to]
    public string $source_channel;
    public $source_id;

    #[Computed()]
    public function sources()
    {
        return BookingSource::cases();
    }

    #[Computed()]
    public function travelAgencies()
    {
        return TravelAgency::where('property_id', $this->property_id)->get();
    }

    #[Computed()]
    public function availableRooms()
    {
        $property = Property::find($this->property_id);
        return $property?->rooms ?? [];
    }

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
            'source_channel' => 'required|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->source_channel == BookingSource::TravelAgency->value) {
            $data['source_type'] = TravelAgency::class;
            $data['source_id'] = $this->source_id;
        }
        
        $guest = Guest::create($data['guest'] + [
            'property_id' => $this->property_id
        ]);

        $booking = Booking::create($data + [
            'guest_id' => $guest->id
        ]);

        $validRooms = collect($this->selectedRooms)->filter(function ($value) {
            return !empty($value);
        });
        foreach ($validRooms as $roomId => $dates) {
            $booking->rooms()->attach($roomId, [
                'from_date' => $dates['from'] ?? $this->check_in,
                'to_date' => $dates['to'] ?? $this->check_out,
            ]);
        }

        return to_route('bookings.index');
    }
};
