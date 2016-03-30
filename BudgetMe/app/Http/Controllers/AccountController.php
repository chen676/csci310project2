<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;
use App\Models\User;
use Session;

include '../../Library/CSVManager.php';

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
    public function addAccount(Request $request)
    {
    	$user = Session::get('user');
    	$account = new Account([
    		'name' => $request->input('name'),
    	]);
    	$user->accounts()->save($account);
    	$u = User::find($user->id);
    	Session::put('user', $u);

    	return redirect('/dashboard');

    }

    public function uploadCSV()
    {
    	$csvmanager = new CSVManager();
    	return;
    }
}
