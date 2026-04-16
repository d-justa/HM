<?php

use App\Models\Booking;
use App\Models\Payment;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $booking_id;
    public $amount;
    public string $method = 'cash';
    public $paid_at;
    public string $note = '';
    public string $status = 'paid';

    #[Computed()]
    public function bookings()
    {
        return Booking::get();
    }

    public function mount()
    {
        $this->paid_at = now();
    }

    protected function rules()
    {
        return [
            'booking_id' => 'required',
            'amount' => 'required',
            'method' => 'required',
            'paid_at' => 'required',
            'note' => 'nullable',
            'status' => 'nullable',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $booking = Booking::find($this->booking_id);
        $data['property_id'] = $booking->id;

        $payment = Payment::create($data);

        return $this->redirectRoute('payments.index', navigate: true);
    }
};
