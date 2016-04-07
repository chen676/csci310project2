<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $fillable = ['name'];
	public $timestamps = false;

    public function transaction()
    {
    	return $this->hasMany('App\Models\Transaction');
    }
}
