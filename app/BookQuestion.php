<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookQuestion extends Model
{ 
    public function sections()
    {
        return $this->belongsToMany('App\Section', 'section_book_questions');
    }
/*     public function assignments()
    {
        return $this->belongsToMany('App\Assignment');
    } */
    public function correctAnswer()
    {
        return $this->belongsTo('App\AnswerResponse', 'correct_answer');
    }
   
}
