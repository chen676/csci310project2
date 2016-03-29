<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;
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

    // call whenever a user uploads a new CSV file of transactions to a specific account
    // ATM THIS FUNCTION IS UNUSABLE UNTIL HTML FORM EXISTS
    public function uploadCSV(){

		// FILEPATH BELOW TO CHANGE
		//readfile("http://localhost/Frontend/dashboard.html");
		//modified code from http://www.w3schools.com/php/php_file_upload.asp
		$target_dir = "";
		$target_name = "test.csv";
		$target_file = $target_dir . $target_name;

		return parseCSV($target_file);
		
	}
	// parse the csv file for values
	public function parseCSV($target_file){

		//echo $target_file;

		$transactions = array();

		$file = fopen($target_file,"r");
		$header = fgetcsv($file);
		while($row = fgetcsv($file)){

			// format: CATEGORY (STRING), AMOUNT (INT), MERCHANT (STRING), DATE (STRING)
			$single_transaction = array($row[0], intval($row[1]), $row[2], $row[3]);
			$transactions[] = $single_transaction;
		}
		fclose($file);

		/* debugging echos
		foreach($transactions as $single){
			echo "CATEGORY=" . $single[0] . ", AMOUNT=" . $single[1] . ", MERCHANT=" . $single[2] . ", DATE=" . $single[3];
			echo "<br>";
		}
		*/

		/* OVERALL FORMAT OF TRANSACTIONS MULTIDIMENSIONAL ARRAY

			Food | 300 | Ralph's | 11/12/1996
			Bills | 1000 | USC | 12/03/2005

			transactions[0] would return the entire first array
			transactions[0][2] would return "Ralph's"
			transactions[1][1] would return 1000

		*/
		//return "test";
		return $transactions;
	}
}
