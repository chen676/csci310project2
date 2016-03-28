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
	
	$accounts = $accounts->toArray();
	usort($accounts, function($lhs, $rhs)
	{
		return strcmp($lhs['name'], $rhs['name']);
	});

	foreach($accounts as $acc)
	{
		var_dump($acc['name']);
		echo "<br>";
	}
    }
}
