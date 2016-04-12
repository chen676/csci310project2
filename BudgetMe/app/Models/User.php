<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

	public $timestamps = false;

	/*
		Parameters: None

		Description: None

		Returns: associated accounts with user

		Created By: Patrick and Brandon
	*/
	public function accounts()
	{
		return $this->hasMany('App\Models\Account');
	}

	/*
		Parameters: None

		Description: N/A

		Returns: Budgets for this user

		Created By: Patrick and Brandon
	*/
	public function budgets()
	{
		return $this->hasMany('App\Models\Budget');
	}




}
