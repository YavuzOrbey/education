<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
    public function correctAnswer(){
        return $this->belongsTo('App\AnswerResponse');
    }
    public function answer(){
        return $this->hasOne('App\Answer');
    }
    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function assignments(){
        return $this->belongsToMany('App\Assignment');
    }

    public function quizzes(){
        return $this->belongsToMany('App\Quiz', 'quiz_questions')->withPivot('sequence');
    }
}
