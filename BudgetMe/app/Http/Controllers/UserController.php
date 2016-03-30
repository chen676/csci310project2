<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Budget;
use Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
    	$user = User::with('accounts', 'budgets')
    	->where('email', '=', $request->input('email'))
    	->where('password', '=', $request->input('password'))
    	->first();

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
    		'user' => Session::get('user'),
		'transactionSet' => Session::get('transactionSet'),
		'checkedAccounts' => Session::get('checkedAccounts')
    	]);
    }

    public function getTransactionSet(Request $request)
    {
	if($request->ajax())
	{
		if($_POST['length'] == 0)
		{
			Session::put('checkedAccounts', array());
    			Session::put('transactionSet', array());
			return;
		}

		$accountNames = $_POST['accountSet'];

		//need to create an array based on id, not name
		$accountIDs = array();
		foreach($accountNames as $name)
		{
			$account = Account::where('name', '=', $name)
			->get()->first();
			array_push($accountIDs, $account->id);
		}

		Session::put('checkedAccounts', $accountNames);

		$transactionSet = array();
		foreach($accountIDs as $acc_id)
		{
			$transaction = Transaction::where('account_id', '=', $acc_id)
			->get();
			$transaction = $transaction->toArray();
			$transactionSet = array_merge($transactionSet, $transaction);
		}
    		Session::put('transactionSet', $transactionSet);
		return $transactionSet;
	}
    }

    public function sortTransactionSetByDate()	
    {
	   $transactionSet = Session::get('transactionSet');
	   if(!is_null($transactionSet))
	   {
		   usort($transactionSet, function($lhs, $rhs)
		   {
			   //indeces of date MM/DD/YYYY
			   $m = 0;
			   $d = 1;
			   $y = 2; 

			   $ldate = explode('/', $lhs['date']);
			   $rdate = explode('/', $rhs['date']);
			   if(strcmp($ldate[$y], $rdate[$y]) > 0) //if left is chronologically more recent
				   return -1;
			   if(strcmp($ldate[$y], $rdate[$y]) < 0) //if right is more recent
				   return 1;
			   //the years must be equal
			   if(strcmp($ldate[$m], $rdate[$m]) > 0) //if left is chronologically more recent
				   return -1;
			   if(strcmp($ldate[$m], $rdate[$m]) < 0) //if right is more recent
				   return 1;	
			   if(strcmp($ldate[$d], $rdate[$d]) > 0) //if left is chronologically more recent
				   return -1;
			   if(strcmp($ldate[$d], $rdate[$d]) < 0) //if right is more recent
				   return 1;
			   return 0; //equal dates	
		   });
       	Session::put('transactionSet', $transactionSet);
	   }
    	return redirect('/dashboard');
    }

    public function sortTransactionSetByCategory()
    {
	$transactionSet = Session::get('transactionSet');
	if(!is_null($transactionSet))
	{
		usort($transactionSet, function($lhs, $rhs)
		{
			return strcmp($lhs['category'], $rhs['category']);
		});
	    	Session::put('transactionSet', $transactionSet);
	}
	return redirect('/dashboard');
    }

    public function sortTransactionSetByAmount()
    {	
	$transactionSet = Session::get('transactionSet');
	if(!is_null($transactionSet))
	{
		usort($transactionSet, function($lhs, $rhs)
		{
			return $lhs['amount'] < $rhs['amount'];
		});
	    	Session::put('transactionSet', $transactionSet);
	}
    	return redirect('/dashboard');
    }
 
    public function logout(Request $request)
    {
    	Session::forget('user');
    	Session::forget('transactionSet');
    	Session::forget('selected_accounts');
    	Session::forget('checkedAccounts');
    	return redirect('/');
    }
}
