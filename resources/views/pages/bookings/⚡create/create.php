<?php

use App\Models\Booking;
use Livewire\Component;

new class extends Component
{
    public $property_id;
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
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $booking = Booking::create($data);

        return to_route('bookings.index');
    }
};
