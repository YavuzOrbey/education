<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionBookQuestion extends Model
{
    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function question(){
        return $this->belongsTo('App\BookQuestion');
    }
}
