<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

	/*
		Parameters: None

		Description: None

		Returns: Return relevant user account

		Created By: Patrick and Brandon
	*/
    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
