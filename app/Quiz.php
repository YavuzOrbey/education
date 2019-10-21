<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function questions(){
        return $this->belongsToMany('App\Question', 'quiz_questions')->withPivot('sequence');
    }

    public function gridQuestions(){
        return $this->belongsToMany('App\GridQuestion', 'quiz_grid_questions')->withPivot('sequence');
    }
}
