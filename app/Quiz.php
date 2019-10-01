<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function gridQuestions(){
        return $this->hasMany('App\GridQuestion');
    }
}
