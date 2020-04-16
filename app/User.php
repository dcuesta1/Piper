<?php

namespace App;

use App\Bin\Auth\Traits\CanResetPasswordTrait as CanResetPassword;
use App\Bin\Auth\Traits\HasTokenAuthenticationTrait as HasTokenAuthentication;
use App\Bin\Auth\User as AuthUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Foundation\Auth\User as Auser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades;
/*
 * @mixin Eloquent
 */
class User extends Authuser
{

    const BASIC_USER = 2;
    const COMPANY_ADMIN_USER = 4;
    const DEVELOPER_USER = 64;

    protected $fillable = [
        'name', 'email', 'password','username','phone'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
      'deleted_at'
    ];

    // Relationships

    public function spaces()
    {
        return $this->belongsToMany('App\Space', 'user_space_pivot');
    }

    public function projects()
    {
        return $this->hasManyThrough('App\Project', 'App\Space');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket', 'creator_id', 'id');
    }

    public function authTokens()
    {
        return $this->hasMany('App\AuthToken');
    }
}
