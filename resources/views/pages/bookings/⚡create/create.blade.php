<div>
    <form wire:submit="save" class="space-y-4">
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