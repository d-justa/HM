<div class="flex-1 flex items-center justify-center">
    <flux:card class="w-full lg:max-w-xl">
        <form wire:submit="login" class="space-y-4">
            <flux:input type="email" label="Email" wire:model="email" required />
            <flux:input type="password" label="Password" wire:model="password" required />
            <flux:button type="submit" variant="primary" class="w-full">Login</flux:button>
        </form>
    </flux:card>
</div>