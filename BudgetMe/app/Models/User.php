<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

	public function accounts()
	{
		return $this->hasMany('App\Models\Account');
	}

	public function budgets()
	{
		return $this->hasMany('App\Models\Budget');
	}




}