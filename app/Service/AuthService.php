<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    //hackday- security = 0
    public function authenticateUser(string $username): bool
    {
        $user = User::where('username', $username)->first();
        Auth::login($user);

        return true;
    }
}
