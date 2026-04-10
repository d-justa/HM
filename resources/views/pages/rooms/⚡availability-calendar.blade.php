<?php

use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

new class extends Component {
    public $currentMonth;
    public $days = [];
    public $rooms;

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
                            class="h-12 border-b border-l transition-colors cursor-pointer text-[10px] flex items-center justify-center
        {{ $activeBooking ? 'bg-red-500 hover:bg-red-600 text-white font-bold' : 'hover:bg-gray-50' }}">

                            @if ($activeBooking)
                                #{{ $activeBooking->id }}
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
    </div>
</div>
