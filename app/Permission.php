<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $casts = [
        'id' => 'integer'
    ];

    public function role()
    {
        return $this->belongsToMany('App\Role', 'permission_role_pivot');
    }
}
