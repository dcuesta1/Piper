<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $casts = [
      'id' => 'integer'
    ];

    public function space()
    {
        return $this->belongsTo('App\Space');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }
}
