<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridQuestion extends Model
{
    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function quizzes(){
        return $this->belongsToMany('App\Quiz', 'quiz_grid_questions')->withPivot('sequence');
    }
}
