<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    /* public function questions(){
        return $this->hasMany('App\BookQuestion');
    } */
    public function sections(){
        return $this->hasMany('App\Section');
    }
    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'sections');
    }
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
