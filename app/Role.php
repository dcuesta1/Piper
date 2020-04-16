<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $casts = [
      'id' => 'integer'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission_role_pivot');
    }
}
