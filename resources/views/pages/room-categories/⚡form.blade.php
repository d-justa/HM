<?php

use App\Models\RoomCategory;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public ?RoomCategory $roomCategory = null;

    public $property_id = 1;
    public string $name = '';
    public string $description = '';

    public function mount(?RoomCategory $roomCategory = null)
    {
        if ($roomCategory && $roomCategory->exists) {
            $this->fill($roomCategory->toArray());
        }
    }

    protected function rules()
    {
        return [
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        RoomCategory::updateOrCreate([
            'id' => $this->roomCategory?->id
        ],$data);

        $this->reset();

         Flux::toast(
            heading: 'Changes saved',
            text: 'Your changes have been saved.',
            variant: 'success',
        );

        return $this->redirectRoute('room-categories.index', navigate: true);
    }
};
?>

<div>
    <form wire:submit="save" class="space-y-4">
        <flux:card>
            <div class="space-y-4">
                <flux:input label="Name" wire:model="name" required />
                <flux:textarea label="Description" wire:model="description" />
            </div>
        </flux:card>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
