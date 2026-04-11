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

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
