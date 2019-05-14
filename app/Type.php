<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /// users can have different types
    public function users(){
        return $this->hasMany('App\User');
    }
}
