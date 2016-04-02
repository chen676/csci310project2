<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	public $timestamps = false;
    public function account()
    {
    	return $this->belongsTo('App\Models\Account');
    }
}
