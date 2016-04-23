<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Budget;
use Session;

use App\Library\TransactionManager;

class UserController extends Controller
{
	/*
        Parameters: Route Request

        Description: Check the login credentials with the user accounts on the MySQL database, and redirect accordingly

        Returns: Route Redirect to Dashboard or back to Login

        Created By: Brandon and Patrick
    */
    public function login(Request $request){

        $user = User::where('email', '=', $request->input('email'))->first();
        $salt = $user->salt;
        $password = $request->input('password');
        $encrypted_password = hash('sha256', $password . '' . $salt);

    	$user = User::with('accounts', 'budgets')
    	->where('email', '=', $request->input('email'))
    	->where('password', '=', $encrypted_password)
    	->first();

    	if (count($user) == 1)
    	{
    		Session::put('user', $user);
    		return redirect('/dashboard');
    	}

    	//user info is incorrect, display errors
    	return redirect('/')->with('loginErrors', true);
    }

    /*
        Parameters: N/A

        Description: Returns the Dashboard page with the current Session attributes

        Returns: Route Redirect to Dashboard if session is null, otherwise return a view populated with all relevant user data

        Created By: Brandon and Matt
        Edited By: Paul and Rebecca
    */
    public function dashboard(){

    	if (is_null(Session::get('user')))
    	{
    		return redirect('/');
    	}

    	return view('dashboard', [
    	   'user' => Session::get('user'),
		  'transactionSet' => Session::get('transactionSet'),
		  'checkedAccounts' => Session::get('checkedAccounts')]);
    }

    /*
        Parameters: N/A

        Description: Clear the current checked accounts and displayed transactions

        Returns: Route Redirect to Dashboard

        Created By: Patrick and Brandon
    */
    public function clearList(){

      Session::put('checkedAccounts', array());
      Session::put('transactionSet', array());
      return redirect('/dashboard');
    }
         
    /*
        Parameters: Route Request

        Description: Retrieve the appropriate transaction set to a checked account

        Returns: Array of transactions of the specific account

        Created By: Paul and Rebecca
    */
    public function getTransactionSet(Request $request){

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
          $user = Session::get('user');
	      foreach($accountNames as $name)
	      {
		      $account = Account::where('name', '=', $name)
              ->where('user_id', '=', $user->id)
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
       	
       	//sort by date default
	    $transactionManager = new TransactionManager();
	    $newTransactionSet = $transactionManager -> sortTransactionsByDates($transactionSet);
       	Session::put('transactionSet', $newTransactionSet);
	      return $transactionSet;
      }
    }

    /*
        Parameters: N/A

        Description: Sort the transaction set being the displayed by date chronologically

        Returns: Route Redirect to Dashboard

        Created By: Paul and Rebecca
    */
    public function sortTransactionSetByDate(){

	   $transactionSet = Session::get('transactionSet');
	   if(!is_null($transactionSet))
	   {
       		$transactionManager = new TransactionManager();
       		$newTransactionSet = $transactionManager -> sortTransactionsByDates($transactionSet);
       		Session::put('transactionSet', $newTransactionSet);
	   }
    	return redirect('/dashboard');
    }

    /*
        Parameters: N/A

        Description: Sort the transaction set being the displayed by category alphabetically

        Returns: Route Redirect to Dashboard

        Created By: Paul and Rebecca
    */
    public function sortTransactionSetByCategory(){

		$transactionSet = Session::get('transactionSet');
		if(!is_null($transactionSet))
		{
	       	$transactionManager = new TransactionManager();
	       	$newTransactionSet = $transactionManager -> sortTransactionsByCategory($transactionSet);
		    Session::put('transactionSet', $newTransactionSet);
		}
		return redirect('/dashboard');
    }

    /*
        Parameters: N/A

        Description: Sort the transaction set being the displayed by amount from least to greatest

        Returns: Route Redirect to Dashboard

        Created By: Paul and Rebecca
    */
    public function sortTransactionSetByAmount(){

		$transactionSet = Session::get('transactionSet');
		if(!is_null($transactionSet))
		{
			$transactionManager = new TransactionManager();
	       	$newTransactionSet = $transactionManager -> sortTransactionsByAmount($transactionSet);
		    Session::put('transactionSet', $newTransactionSet);
		}
	    return redirect('/dashboard');
    }

    /*
        Parameters: Route Request

        Description: Logout of the logged-in user

        Returns: Route Redirect to Login

        Created By: Patrick and Brandon
        Edited By: Paul and Rebecca
    */
    public function logout(Request $request){
        
    	Session::forget('user');
    	Session::forget('transactionSet');
    	Session::forget('selected_accounts');
    	Session::forget('checkedAccounts');
    	return redirect('/');
    }
}
