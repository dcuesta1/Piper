<?php

namespace App\Bin\Auth;
/**
 * @method static id
 * @method static getUser
 * @method static loginWithCredentials(array $credentials)
 * @method static getUserByPasswordResetCode(int $code)
 * @method static createToken()
 * @method static createRefreshToken()
 * @method static decryptRefreshToken()
 *
 * @see AuthManager
 */
use Illuminate\Support\Facades\Facade;

class AuthFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'Auth'; }
 }
