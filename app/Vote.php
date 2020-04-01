<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
    public function election()
    {
        return $this->belongsTo('App\Election', 'foreign_key');
    }

    public function user_voted(){
        return $this->belongsTo('App\User');
    }
}
