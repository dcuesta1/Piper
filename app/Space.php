<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{

    protected $with = ['projects'];
    protected $hidden = ['pivot'];

    protected $casts = [
      'id' => 'integer'
    ];

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function spaces()
    {
        return $this->belongsToMany('App\User', 'user_space_pivot');
    }
}
