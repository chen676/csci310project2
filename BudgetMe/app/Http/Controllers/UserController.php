<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Transaction;
use Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
    	$user = User::with('accounts', 'budgets')
    	->where('email', '=', $request->input('email'))
    	->where('password', '=', $request->input('password'))
    	->get();

    	if (count($user) == 1)
    	{
    		Session::put('user', $user);
    		return redirect('/dashboard');
    	}

    	//user info is incorrect, display errors
    	return redirect('/')->with('loginErrors', true);
    }

    public function dashboard()
    {
    	if (is_null(Session::get('user')))
    	{
    		return redirect('/');
    	}

    	return view('dashboard', [
    		'user' => Session::get('user')
    	]);
    }

    public function getTransactionSet()
	{
	$transaction = Transaction::with('account')
	->where('account_id', '=', 1)	
	->get();
	foreach($transaction as $acc)
	{
		var_dump($acc->merchant);
		var_dump($acc->date);
		echo "<br>";
	}
    }
 
    public function logout(Request $request)
    {
    	Session::forget('user');
    	return redirect('/');
    }
}
