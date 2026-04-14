<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="space-y-4">
                <flux:input label="Name" wire:model="name" required />
                <flux:input type="number" label="Default Price" wire:model="default_price" min="0" />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
