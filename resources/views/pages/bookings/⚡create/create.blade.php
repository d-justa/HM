<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="First Name" wire:model="guest.first_name" required />
                <flux:input label="Last Name" wire:model="guest.last_name" />
                <flux:input type="email" label="Email" wire:model="guest.email" />
                <flux:input label="Phone" wire:model="guest.phone" />
            </div>
        </flux:card>

        <flux:card>
            <div class="grid grid-cols-2 gap-4">
                <flux:input type="date" label="Check in" x-model="$wire.check_in" :min="now()->format('Y-m-d')"
                    required />
                <flux:input type="date" label="Check out" x-model="$wire.check_out"
                    x-bind:min="new Date(new Date($wire.check_in).getTime() + 86400000).toISOString().split('T')[0]"
                    required />
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:select label="Source" x-model="$wire.source_channel">
                @foreach ($this->sources as $source)
                    <flux:select.option :value="$source->value">{{ Str::headline($source->name) }}</flux:select.option>
                @endforeach
            </flux:select>

            <template x-if="$wire.source_channel == 'travel-agency'">
                <flux:select label="Travel Agency" wire:model="source_id" required>
                    <flux:select.option value=""></flux:select.option>
                    @foreach ($this->travelAgencies as $agency)
                        <flux:select.option :value="$agency->id">{{ $agency->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </template>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
