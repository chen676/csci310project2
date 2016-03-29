<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $fillable = ['name'];
	public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function transaction()
    {
    	return $this->hasMany('App\Models\Transaction');
    }
}
