<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Account extends Model
{
	protected $fillable = ['name'];
	public $timestamps = false;

	/*
		Parameters: None

		Description: return transactions associated

		Returns: transactions associated

		Created By: Patrick and Brandon
	*/
    public function transaction()
    {
    	return $this->hasMany('App\Models\Transaction');
    }
}
