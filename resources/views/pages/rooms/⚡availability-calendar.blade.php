<?php

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

new class extends Component {
    public $currentMonth;
    public $days = [];
    public $rooms;
    public ?Booking $showingBooking = null;

    public function showBooking($id)
    {
        // Eager load guest and source for the flyout
        $this->showingBooking = Booking::with(['guest', 'rooms'])->find($id);

        // This triggers the Flux modal via Javascript
        $this->js("Flux.modal('show-booking').show()");
    }

    public function mount()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->generateDays();
        $this->rooms = Room::all();
    }

    public function generateDays()
    {
        // Generates an array of Carbon dates for the current month
        $period = CarbonPeriod::create($this->currentMonth->copy()->startOfMonth(), $this->currentMonth->copy()->endOfMonth());
        $this->days = $period->toArray();
    }

    public function nextMonth()
    {
        $this->currentMonth->addMonth();
        $this->generateDays();
    }

    public function prevMonth()
    {
        $this->currentMonth->subMonth();
        $this->generateDays();
    }
};
?>

<div>
    <div class="p-4 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">{{ $currentMonth->format('F Y') }}</h2>
            <div class="space-x-2">
                <button wire:click="prevMonth" class="px-3 py-1 border rounded hover:bg-gray-100">&lt;</button>
                <button wire:click="nextMonth" class="px-3 py-1 border rounded hover:bg-gray-100">&gt;</button>
            </div>
        </div>

        <div class="overflow-x-auto border rounded">
            <div class="grid" style="grid-template-columns: 150px repeat({{ count($days) }}, minmax(40px, 1fr));">

                <div class="sticky left-0 z-10 p-2 font-bold bg-gray-50 border-b">Room</div>
                @foreach ($days as $date)
                    <div
                        class="p-2 text-center text-xs font-semibold border-b border-l {{ $date->isToday() ? 'bg-blue-50 text-blue-600' : 'bg-gray-50' }}">
                        {{ $date->format('d') }}<br>
                        <span class="text-[10px] uppercase">{{ $date->format('D') }}</span>
                    </div>
                @endforeach

                @foreach ($rooms as $room)
                    <div class="sticky left-0 z-10 p-2 text-sm font-medium bg-white border-b shadow-sm">
                        {{ $room->name }}
                        <br>
                        <flux:text class="text-xs">{{ $room->category->name }}</flux:text>
                    </div>

                    @foreach ($days as $date)
                        @php
                            // Use 'first' instead of 'contains' to get the actual booking record
                            $activeBooking = $room->bookings->first(function ($booking) use ($date) {
                                $from = $booking->pivot->from_date;
                                $to = $booking->pivot->to_date;

                                return $date->between($from, $to->copy()->subDay());
                            });
                        @endphp

                        <div
                            class="h-14 border-b border-l transition-colors cursor-pointer text-[10px] flex items-center justify-center">

                            @if ($activeBooking)
                                <flux:button wire:click="showBooking({{ $activeBooking->id }})" variant="ghost"
                                    size="xs"  :loading="false">
                                    #{{ $activeBooking->id }}
                                </flux:button>
                            @endif

                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 mt-4 text-xs">
            <div class="flex items-center gap-1"><span class="w-3 h-3 bg-red-500 rounded"></span> Booked</div>
            <div class="flex items-center gap-1"><span class="w-3 h-3 border rounded"></span> Available</div>
        </div>

        <flux:modal name="show-booking" flyout>
            <div class="space-y-6">
                @if ($showingBooking)
                    <div>
                        <flux:heading size="lg">Booking #{{ $showingBooking->id }}</flux:heading>
                        <flux:subheading>{{ $showingBooking->guest->first_name }}
                            {{ $showingBooking->guest->last_name }}</flux:subheading>
                    </div>

                    <flux:separator />

                    <div class="space-y-4">
                        <flux:legend>Stay Information</flux:legend>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:text size="sm">Check-in:
                                <b>{{ $showingBooking->check_in->format('d M, Y') }}</b>
                            </flux:text>
                            <flux:text size="sm">Check-out:
                                <b>{{ $showingBooking->check_out->format('d M, Y') }}</b>
                            </flux:text>
                        </div>

                        <flux:separator variant="subtle" />

                        <flux:legend>Guest Contact</flux:legend>
                        <flux:text size="sm">Email: {{ $showingBooking->guest->email ?? 'N/A' }}</flux:text>
                        <flux:text size="sm">Phone: {{ $showingBooking->guest->phone ?? 'N/A' }}</flux:text>
                    </div>

                    <div class="flex">
                        <flux:spacer />
                        <flux:button variant="danger" wire:click="deleteBooking({{ $showingBooking->id }})"
                            wire:confirm="Are you sure?">Cancel Booking</flux:button>
                    </div>
                @else
                    <div class="flex justify-center py-10">
                        {{-- <flux:icon.spinner class="animate-spin" /> --}}
                    </div>
                @endif
            </div>
        </flux:modal>
    </div>
</div>
