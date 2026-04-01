<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::guest')] class extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules()
    {
        return [
            'email'     => 'required|string',
            'password'  => 'required|string'
        ];
    }

    public function login()
    {
        $credentials = $this->validate();

        if (!Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed')
            ]);
        }

        Session::regenerate();

        return to_route('dashboard');
    }
};
