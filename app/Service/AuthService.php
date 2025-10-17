<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthService
{

    //hackday- security = 0
    public function authenticateUserCreateIfNotExist(string $username): bool
    {
        
        $userExists = User::where('username', $username)->exists();
     
        if(!$userExists)
        {
            $createUser = User::create([
                'email' => 'annon_'. Carbon::now()->unix(). 'maeplet.com',
                'password' => 'password password',
                'username' => $username,
                'name' => $username
            ]);

           Auth::login($createUser);

           return true;
        }


        $user = User::where('username', $username)->first();
        Auth::login($user);

        return true;
    }
}
