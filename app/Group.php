<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function assignments(){
        return $this->belongsToMany('App\Assignment')->using('App\AssignmentGroup')->withPivot('due_date');
    }
}
