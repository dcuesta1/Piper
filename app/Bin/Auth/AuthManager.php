<?php


namespace App\Bin\Auth;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthManager
{
    protected   $user,
                $token,
                $request,
                $isUserSet = false;

    public function __construct(User $user, Request $request, Token $token)
    {
        $this->request = $request;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Gets the authentication token for the current user/request.
     *
     * @return Token
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Sets the authentication token for the current user/request.
     * @param Token $token
     * @return void
     */
    private function setToken(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Gets the current user.
     *
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Sets the user in the current Manager instance.
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        /*
        * Note: When the instance of this class is created, its injected with an "empty" instance of the App\Bin\Auth\User:class
        * $this->isUserSet helps check if the user property has been repopulated with fetched data from db.
        */
        $this->isUserSet = true;
        $this->user = $user;
    }

    /**
     * Checks if user has been populated with fetched data from db.
     *
     * @return bool
     */
    private function issetUser()
    {
        return $this->isUserSet;
    }

    /**
     * Gets the id of the current user.
     *
     * @return int|null Returns null if there is no current user.
     */
    public function id()
    {
        if ( !$this->user() ) {
            return false;
        }

        return $this->user()->getId();
    }

    /**
     * Logs in an user using their user database identifier (e.g. username, email) and password credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function checkCredentials(array $credentials)
    {
        $col = $this->user->getUserDatabaseIdentifier();
        $user = $this->user->getByIdentifier($credentials[$col]);

        if ( $user && PasswordManager::check($credentials['password'], $user->password)) {
            $this->setUser($user);
            return true;
        }

        return false;
    }

    //TODO: no idea what this is for..
    public function setCheckToken(string $token)
    {
        $value = $this->request->header('Authorization');
        $token = $value ? $this->token->getByValue($value) : null;
    }

    /**
     *  Creates an authorization token for the current user.
     *
     * @param string $clientId
     * @return Token|null Returns null if there is no current user.
     */
    public function createToken(string $clientId = null)
    {
        $clientMetaData = $this->request->header('user-agent');

        if ( !$this->user() ) {
            return null;
        }

        if ( !empty($clientId) && !is_null($this->token = $this->token->getByClientId($clientId)) ) {
            $this->refreshToken($this->token);
        } else {
            $this->token = $this->user()->createToken($clientMetaData, $clientId);
        }

        return $this->token();
    }

    /**
     * Refreshes (update) an existing token for the current user. (redo)
     *
     * @param string|null $clientMetaData
     * @return void
     */
    public function refreshToken(string $clientMetaData = null)
    {
        $this->token = $this->user->refreshToken($this->token);
    }


    /**
     * Attempts to authorize an user's authentication key.
     *
     * @param string $token
     * @throws ApiException
     * @return void
     */
    public function attempt(string $token)
    {
        if ( $this->token && !$this->isTokenExpired()) {
            $this->setUser($this->token->user);
        }
    }

    /**
     * Gets an user by password reset code.
     *
     * @param int $code
     * @return User $user
     */
    public function getUserByPasswordResetCode(int $code)
    {
        return $this->user->getUserByPasswordResetCode($code);
    }

    /**
     * Checks if the current token in the request is expired.
     *
     * @return bool
     * @throws ApiException
     */
    protected function isTokenExpired()
    {
        if ( !$this->token ) {
            throw new ApiException('No token set on auth manager');
        }

        return $this->token->isExpired();
    }
}
