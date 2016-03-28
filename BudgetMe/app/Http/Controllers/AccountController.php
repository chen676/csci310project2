<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;

class AccountController extends Controller
{
    public function sortAccounts()
    {
	$accounts = Account::with('user')
	->where('user_id', '=', 1)	
	->get();
	
	$accountsAlphaSorted = array();
	foreach($accounts as $acc)
	{
		$accountsAlphaSorted[$acc->name] = $acc;
	}

	ksort($accountsAlphaSorted);

	foreach($accountsAlphaSorted as $acc)
	{
		var_dump($acc->name);
		echo "<br>";
	}
    }
}
