<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="Name" wire:model="name" required />
                    <flux:input label="Website" wire:model="website"  />
                </div>
                <flux:textarea label="Note" wire:model="note" />
            </div>
        </flux:card>

        <flux:card>
            <flux:heading>Address Details</flux:heading>
            <flux:separator class="my-2" />
            <div class="grid grid-cols-3 gap-4">
                <flux:input label="Address Line 1" wire:model="address.line_1" />
                <flux:input label="Address Line 2" wire:model="address.line_2" />
                <flux:input label="City" wire:model="address.city" />
                <flux:input label="State" wire:model="address.state" />
                <flux:input label="Zip" wire:model="address.zip" />
                <flux:input label="Country" wire:model="address.country" />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
