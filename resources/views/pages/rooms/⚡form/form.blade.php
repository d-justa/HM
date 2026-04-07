<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="space-y-4">
                <flux:select label="Room Category" wire:model="room_category_id" required>
                    <flux:select.option value=""></flux:select.option>
                    @foreach ($this->roomCategories as $category)
                        <flux:select.option :value="$category->id">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input label="Name" wire:model="name" required />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
