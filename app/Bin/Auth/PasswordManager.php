<?php

namespace App\Bin\Auth;

use Illuminate\Support\Facades\Hash;

class PasswordManager
{
    public static function hash($password)
    {
        return Hash::make($password);
    }

    public static function needsRehash($hashValue)
    {
        return Hash::needsRehash($hashValue);
    }

    public static function check($password, $hashPassword)
    {
        return Hash::check($password, $hashPassword);
    }

}
