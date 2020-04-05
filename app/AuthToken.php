<?php


namespace App;


class AuthToken
{
    protected  $fillable = ['clientId'];
    protected $casts = [
      'id' => 'integer',
      'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo('user');
    }
}
