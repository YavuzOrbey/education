<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function questions(){
        return $this->hasMany('App\Question');
    }
    public function assignments()
    {
        return $this->belongsToMany('App\Assignment', 'sections');
    }
    public function sections(){
        return $this->hasMany('App\Section');
    }
}
