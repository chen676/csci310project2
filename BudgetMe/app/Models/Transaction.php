<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = ['category', 'amount', 'merchant', 'date'];
	public $timestamps = false;

    public function account()
    {
    	return $this->belongsTo('App\Models\Account');
    }
}
