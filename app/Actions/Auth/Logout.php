<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }
}
