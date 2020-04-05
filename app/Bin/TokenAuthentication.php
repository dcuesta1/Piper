<?php

namespace App\Bin;

use App\Exceptions\UnauthorizedAccessException;
use App\AuthToken;
use Auth;
use Carbon\Carbon;
use Hash;

class TokenAuthentication
{
    private $_refreshed = null;

    public function attempt($token)
    {
        $this->_refreshed = null;

        if(!$token = AuthToken::where('value', $token)->first()) {
            throw new UnauthorizedAccessException('INVALID TOKEN');
        }

        $expirationDate = Carbon::parse($token->updated_at)->addDays(30);

        if($expirationDate <= Carbon::now()) {
            throw new UnauthorizedAccessException('EXPIRED TOKEN');
        }

        if ($expirationDate->diffInDays(Carbon::now()) <= 7) {
            $this->_refreshed = $token->value;
            $token->value = $this->hash();
            $token->save();
        }

        Auth::login($token->user);
    }

    public static function hash($length = 64)
    {
        return bin2hex(random_bytes($length));
    }

    public function encrypt($password)
    {
        return bcrypt($password);
    }

    public function refreshed()
    {
        return $this->_refreshed;
    }
}
