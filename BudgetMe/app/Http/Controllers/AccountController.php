<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;
use App\Models\User;
use App\Models\Transaction;
use Session;

use App\Library\CSVManager;

use App\Library\AccountManager;


class AccountController extends Controller
{
    public function sortAccounts()
    {
    	$accounts = Account::with('user')
    	->where('user_id', '=', 1)	
    	->get();
    	
        $accounts = $accounts->toArray();

        $accountManager = new AccountManager();
        $accountList = $accountManager->sortAccountsByNames();

        foreach($accountList as $acc)
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

    public function removeAccount(Request $request)
    {
		$id = $request->input('account_id');
		$account = Account::find($id);
		$account->transaction()->delete();
		$account->delete();

		$user = Session::get('user');
		$u = User::find($user->id);
		Session::put('user', $u);

		return redirect('/clearList');
    }
    
    public function uploadCSV(Request $request)
    {
    	
    	if (!$request->hasFile('csv')){
    		return redirect('/dashboard');
    	}
    	$id = $request->input('account_id');
    	$file = $request->file('csv');
    	$path = base_path() . '/upload';
    	$file->move($path, $file->getClientOriginalName());
    	$target_file = $path . '/' . $file->getClientOriginalName();
    	$csvm = new CSVManager();
    	$transactions = $csvm -> parseCSV($target_file);

    	foreach ($transactions as $t){


    		$single = new Transaction;

    		$single->category = $t[0];
    		$single->amount = $t[1];
    		$single->merchant = $t[2];
    		$single->date = $t[3];
    		$single->account_id = $id;

    		$single->save();

    		
    	}
    	
    	return redirect('/dashboard');
    }

    /*
        param: category is a string that represents which category of transactions to sum
        return: returns a float, the total sum of transactions
        written by Rebecca/Paul
    */
    public function sumCategoryTransaction(){
        //need to build a list of all accounts tied to the user
        $id = 1; //will be a parameter later
        $cat = "Rent";
        $sum = 0.00;

        $accounts = Account::where('user_id', '=', $id)->get();
        $transSet = array();
        foreach($accounts as $acc){
            echo $acc['id'];

            $transactions = Transaction::where('category', '=', $cat)
            ->where('account_id', '=', $acc['id'])->get();

            foreach($transactions as $trans){
                $sum += $trans['amount'];
            }
        }
        echo $sum;
        return;
    }
}
