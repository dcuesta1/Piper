<?php

namespace App\Bin\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    const EXPIRATION_IN_DAYS = 15;

    protected $table = 'auth_tokens';
    protected $fillable = ['client_id', 'value', 'client_metadata'];
    protected $visible = ['value', 'client_id'];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer'
    ];
    protected $dates = [
      'expires_at'
    ];

    private $dbIdentifier;

    public function __construct(array $attributes = [])
    {
        $this->dbIdentifier = config('auth.providers.auth_token.auth_token_identifier');

        parent::__construct($attributes);
    }

    public function getByValue(string $value)
    {
        return $this->newQuery()->where($this->getDbIdentifier(), $value)->first();
    }

    public function getByClientId(string $clientId)
    {
        return $this->newQuery()->where('client_id', $clientId)->first();
    }

    public function isExpired()
    {
        return ( $this->expires_at->diffInDays(Carbon::now()) <= Token::EXPIRATION_IN_DAYS );
    }

    // Private Helper functions
    private function getDbIdentifier()
    {
        return $this->dbIdentifier;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo('App\Bin\Auth\User');
    }
}

