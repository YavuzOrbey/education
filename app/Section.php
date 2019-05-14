<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function questions()
    {
        return $this->belongsToMany('App\BookQuestion', 'section_questions');
    }

    public function assignment(){
        return $this->belongsTo('App\Assignment');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}
