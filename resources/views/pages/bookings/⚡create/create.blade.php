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
                <flux:input type="date" label="Check in" wire:model="check_in" required />
                <flux:input type="date" label="Check out" wire:model="check_out" required />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>