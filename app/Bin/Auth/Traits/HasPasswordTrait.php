<?php


namespace App\Bin\Auth\Traits;

use App\Bin\Auth\PasswordManager;
use Illuminate\Support\Facades\Password;

Trait HasPasswordTrait
{
    public function setPasswordAttribute()
    {
        return PasswordManager::hash($this->password);
    }
}
