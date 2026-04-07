<?php

use App\Models\Property;
use App\Models\Room;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public ?Room $room = null;

    public $property_id;
    public $room_category_id;
    public string $name = '';

    #[Computed()]
    public function roomCategories()
    {
        $property = Property::find($this->property_id);
        return $property?->roomCategories;
    }

    public function mount(?Room $room = null)
    {
        $this->property_id = 1;
        
        if ($room && $room->exists) {
            $this->fill($room->toArray());
        }
    }

    protected function rules()
    {
        return [
            'property_id' => 'required',
            'room_category_id' => 'required',
            'name' => 'required|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $room = Room::updateOrCreate([
            'id' => $this->room?->id
        ], $data);


        $this->reset();

        return to_route('rooms.index');
    }
};
