<?php


namespace App\Bin\Auth\Traits;


use App\Bin\Auth\Token;
use App\Exceptions\UnauthorizedAccessException;
use Carbon\Carbon;
use Illuminate\Support\Str;

Trait HasTokenAuthenticationTrait
{
    public function getTokenDatabaseIdentifier()
    {
        return config('auth.providers.auth_token.auth_token_identifier');
    }

    public function getByToken(string $token)
    {

    }


    /**
     * Create and persist a new authentication token for the current user.
     *
     * @param string $clientId
     * @param string $metaData
     * @return Token
     * @throws \Exception
     */
    public function createToken(string $metaData, string $clientId = null)
    {
        $token =  new Token([
            'value' => $this->hash(),
            'client_id' => !is_null($clientId) ? $clientId : Str::uuid(),
            'client_metadata' => $metaData,
        ]);

        $persistedToken = $this->authTokens()->save($token);
        return $persistedToken;
    }

    /**
     * Refreshes|updates an existing authentication token for the user.
     *
     * @param Token $token
     * @return Token
     * @throws \Exception
     */
    public function refreshToken(Token $token)
    {
        $token->value = $this->hash();
        $token->updated_at = Carbon::now();
        $token->save();

        return $token;
    }

    /**
     * Checks if a token is expired.
     *
     * @param Token $token
     * @throws UnauthorizedAccessException
     */
    public function isTokenExpired(Token $token)
    {

        $expirationDate = Carbon::parse($token->updated_at)->addDays(30);

        if($expirationDate <= Carbon::now()) {
            throw new UnauthorizedAccessException('EXPIRED TOKEN');
        }

        if ($expirationDate->diffInDays(Carbon::now()) <= 7) {
            $this->_refreshed = $token->value;
            $token->value = $this->hash();
            $token->save();
        }
    }


    /**
     * Get an instance of the current validated authentication token.
     *
     * @return Token $token
     */
    public function getToken()
    {
        $token = new Token();
        return $token;
    }

    /**
     * Makes a hashed token.
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    protected function hash($length = 64)
    {
        return bin2hex(random_bytes($length));
    }

    // Relationships
    public function authTokens()
    {
        return $this->hasMany('App\Bin\Auth\Token');
    }

}
