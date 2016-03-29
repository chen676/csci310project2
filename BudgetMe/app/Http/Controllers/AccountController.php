<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Session;


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

    public function display_account($id)
    {
    	$account = Account::with('transactions')->find($id);

    	return view('account', [
    		'account' => $account
    	]);
    }

    public function transaction($id)
    {
    	return view('new_transaction', [
    		'account_id' => $id
    	]);
    }

    public function addTransaction(Request $request)
    {
    	$account = Account::find($request->input('account_id'));

    	$transaction = new Transaction([
    		'category' => $request->input('category'),
    		'amount' => $request->input('amount'),
    		'merchant' => $request->input('merchant'),
    		'date' => $request->input('date')
    	]);

    	$account->transactions()->save($transaction);

    	$currentUserID = Session::get('user')->id;
    	$user = User::find($currentUserID);
    	Session::put('user', $user);

    	return redirect('/dashboard');
    }
}
