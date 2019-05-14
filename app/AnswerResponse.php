<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerResponse extends Model
{
    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function book_questions(){
        return $this->hasMany('App\BookQuestion');
    }
}
