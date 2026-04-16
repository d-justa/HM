<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="space-y-4">
                <flux:select label="Booking" wire:model="booking_id" required>
                    <flux:select.option value="">Select</flux:select.option>
                    @foreach ($this->bookings as $booking)
                        <flux:select.option :value="$booking->id">{{ $booking->code }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input type="number" label="Amount" wire:model="amount" min="0" />
                <flux:textarea label="Note" wire:model="note" />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
