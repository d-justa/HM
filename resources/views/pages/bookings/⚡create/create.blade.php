<div>
    <form wire:submit="save" class="space-y-4">
        <flux:input label="Booking No" wire:model="code" required />

        <div class="grid md:grid-cols-2 gap-4">
            <flux:card>
                <flux:heading>Guest Info</flux:heading>
                <flux:separator class="my-2" />
                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="First Name" wire:model="guest.first_name" required />
                    <flux:input label="Last Name" wire:model="guest.last_name" />
                    <flux:input type="email" label="Email" wire:model="guest.email" />
                    <flux:input label="Phone" wire:model="guest.phone" />
                </div>
            </flux:card>

            <flux:card>
                <flux:heading>Trip Details</flux:heading>
                <flux:separator class="my-2" />
                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="date" label="Check in" x-model="$wire.check_in" :min="now()->format('Y-m-d')"
                        required />
                    <flux:input type="date" label="Check out" x-model="$wire.check_out"
                        x-bind:min="new Date(new Date($wire.check_in).getTime() + 86400000).toISOString().split('T')[0]"
                        required />
                    <flux:input type="number" label="Adults" wire:model="adults" min="1" required />
                    <flux:input type="number" label="Children" wire:model="children" min="0" />
                </div>
            </flux:card>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-4">
                <flux:card>
                    <flux:heading>Room Allotment</flux:heading>
                    <flux:separator class="my-2" />

                    <div x-data="{
                        rooms_selected: $wire.entangle('selectedRooms'),
                        rooms_available: {{ $this->availableRooms->toJson() }},
                    
                        addRoom() {
                            this.rooms_selected.push({
                                room_id: '',
                                from_date: $wire.check_in, // Default to main check-in
                                to_date: $wire.check_out, // Default to main check-out
                                is_custom: false // Toggle for custom dates
                            });
                        },
                    
                        removeRoom(index) {
                            this.rooms_selected.splice(index, 1);
                        }
                    }">
                        <template x-for="(item, index) in rooms_selected" :key="index" x-cloak>
                            <div
                                class="p-4 mb-4 border rounded-lg bg-slate-50 dark:bg-white/5 border-slate-200 dark:border-white/10">
                                <div class="flex items-center justify-between mb-4">
                                    <flux:heading size="sm">Room #<span x-text="index + 1"></span></flux:heading>

                                    <div class="flex items-center gap-4">
                                        <button type="button"
                                            x-on:click="rooms_selected[index].is_custom = !rooms_selected[index].is_custom"
                                            class="text-xs font-medium transition-colors"
                                            x-bind:class="rooms_selected[index].is_custom ? 'text-primary-600' :
                                                'text-slate-500 hover:text-slate-700'">
                                            <span
                                                x-text="rooms_selected[index].is_custom ? 'Using Custom Dates' : 'Add Custom Dates'"></span>
                                        </button>

                                        <flux:button x-show="rooms_selected.length > 1" variant="ghost" size="sm"
                                            icon="trash" x-on:click="removeRoom(index)" class="text-red-500" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <flux:select label="Room" x-model="rooms_selected[index].room_id" required
                                        placeholder="Choose a room...">
                                        <template x-for="available in rooms_available" :key="available.id">
                                            <flux:select.option x-bind:value="available.id" x-text="available.name">
                                            </flux:select.option>
                                        </template>
                                    </flux:select>

                                    <flux:input type="date" label="From" x-model="rooms_selected[index].from_date"
                                        x-effect="if(!rooms_selected[index].is_custom) rooms_selected[index].from_date = $wire.check_in"
                                        x-bind:readonly="!rooms_selected[index].is_custom"
                                        x-bind:class="!rooms_selected[index].is_custom && 'opacity-60 bg-slate-100'" />

                                    <flux:input type="date" label="To" x-model="rooms_selected[index].to_date"
                                        x-effect="if(!rooms_selected[index].is_custom) rooms_selected[index].to_date = $wire.check_out"
                                        x-bind:readonly="!rooms_selected[index].is_custom"
                                        x-bind:class="!rooms_selected[index].is_custom && 'opacity-60 bg-slate-100'" />
                                </div>
                            </div>
                        </template>

                        <div class="mt-4">
                            <flux:button variant="subtle" icon="plus" @click="addRoom()">
                                Add Another Room
                            </flux:button>
                        </div>
                    </div>
                </flux:card>

                <flux:card x-data="{
                    addons_selected: $wire.entangle('selectedAddons'),
                    addons_available: {{ $this->availableAddons->toJson() }},
                
                    addAddon() {
                        this.addons_selected.push({
                            addon_id: '',
                            quantity: 1,
                            price_per_unit: 0
                        });
                    },
                
                    removeAddon(index) {
                        this.addons_selected.splice(index, 1);
                    },
                
                    updatePrice(index) {
                        const selected = this.addons_available.find(a => a.id == this.addons_selected[index].addon_id);
                        if (selected) {
                            this.addons_selected[index].price_per_unit = selected.price;
                        }
                    }
                }">
                    <div class="flex items-center justify-between">
                        <flux:heading>Addons</flux:heading>
                        <flux:button variant="subtle" size="sm" icon="plus" @click="addAddon()">Add Addon
                        </flux:button>
                    </div>
                    <flux:separator class="my-2" />

                    <div>
                        <div class="space-y-3">
                            <template x-for="(addon, index) in addons_selected" :key="index" x-cloak>
                                <div
                                    class="flex items-end gap-3 p-3 border rounded-lg bg-slate-50 dark:bg-white/5 border-slate-200 dark:border-white/10">

                                    <div class="flex-1">
                                        <flux:select label="Select Addon" x-model="addons_selected[index].addon_id"
                                            x-on:change="updatePrice(index)">
                                            <flux:select.option value="">-- Choose --</flux:select.option>
                                            <template x-for="item in addons_available" :key="item.id">
                                                <flux:select.option x-bind:value="item.id" x-text="item.name">
                                                </flux:select.option>
                                            </template>
                                        </flux:select>
                                    </div>

                                    <div class="w-24">
                                        <flux:input type="number" label="Qty"
                                            x-model="addons_selected[index].quantity" min="1" />
                                    </div>

                                    <div class="w-32">
                                        <flux:input type="number" label="Price"
                                            x-model="addons_selected[index].price_per_unit" prefix="₹" />
                                    </div>

                                    <div class="w-32 hidden md:block">
                                        <flux:label>Total</flux:label>
                                        <div class="py-2 font-semibold text-slate-700"
                                            x-text="'₹' + (addons_selected[index].quantity * addons_selected[index].price_per_unit)">
                                        </div>
                                    </div>

                                    <flux:button variant="ghost" size="sm" icon="trash"
                                        x-on:click="removeAddon(index)" class="mb-1 text-red-500" />
                                </div>
                            </template>
                        </div>

                        <template x-if="addons_selected.length === 0">
                            <div class="py-4 text-center text-sm text-slate-500">
                                No addons added to this booking yet.
                            </div>
                        </template>
                    </div>
                </flux:card>
            </div>

            <div class="space-y-4">
                <flux:card class="space-y-4">
                    <flux:heading>Additional Details</flux:heading>
                    <flux:separator class="my-2" />
                    <flux:select label="Source" x-model="$wire.source_channel">
                        @foreach ($this->sources as $source)
                            <flux:select.option :value="$source->value">{{ Str::headline($source->name) }}
                            </flux:select.option>
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
                    <flux:textarea label="Note" wire:model="note" />
                </flux:card>
            </div>
        </div>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
