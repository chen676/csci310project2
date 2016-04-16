<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	public $timestamps = false;

	/*
		Parameters: None

		Description: None

		Returns: associated accounts with this user

		Created By: Patrick and Brandon
	*/
    public function account()
    {
    	return $this->belongsTo('App\Models\Account');
    }
}
