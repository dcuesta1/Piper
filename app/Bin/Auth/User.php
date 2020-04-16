<?php


namespace App\Bin\Auth;

use App\AuthToken;
use App\Bin\Auth\Traits\CanResetPasswordTrait as CanResetPassword;
use App\Bin\Auth\Traits\HasTokenAuthenticationTrait as HasTokenAuthentication;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable,
        HasRelationships,
        HasTokenAuthentication,
        CanResetPassword;

    protected $hidden = [
        'password', 'pivot',
    ];

    private $userDatabaseIdentifier;

    public function __construct($att = [])
    {
        $this->userDatabaseIdentifier = config('auth.providers.auth_token.auth_user_identifier');

        parent::__construct($att);
    }

    public function getUserDatabaseIdentifier()
    {
        return $this->userDatabaseIdentifier;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getByIdentifier(string $identifier)
    {
        $user = $this->newQuery()->where($this->getUserDatabaseIdentifier(), $identifier)->first();
        return $user;
    }
}
