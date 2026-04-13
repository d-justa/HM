<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="Name" wire:model="name" required />
                <flux:input label="Subdomain" wire:model="subdomain" required />
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

        <flux:card>
            <div class="flex justify-between items-center">
                <flux:heading>Add Property Manager</flux:heading>
                <flux:field variant="inline">
                    <flux:label>Add</flux:label>
                    <flux:switch x-model="$wire.manager.add" />
                </flux:field>
            </div>
            <template x-if="$wire.manager.add">
                <div class="mt-4 space-y-4">
                    <flux:separator />
                    <div class="grid grid-cols-3 gap-4">
                        <flux:input label="Name" wire:model="manager.name" required />
                        <flux:input type="email" label="Email" wire:model="manager.email" required />
                        <flux:input type="password" label="Password" wire:model="manager.password" required />
                    </div>
                </div>
            </template>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
