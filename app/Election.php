<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    //
    protected $guarded = ['id'];

    public function candidates()
    {
        return $this->hasOne('App\Candidate');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'foreign_key');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // 紐づいているcandidateも削除
    public static function boot()
  {
    parent::boot();

    static::deleting(function($election) {
      $election->candidates()->delete();
    });
  }
}

