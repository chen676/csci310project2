<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Budget;
use Session;
use DB;

use App\Library\TransactionManager;

class GraphController extends Controller{
	public function populateGraph(Request $request){

		if($request->ajax()){
			
			$user = Session::get('user');
			$user_id = $user -> id;
			$starting_date = $request['starting_date'];
			$ending_date = $request['ending_date'];
			$accounts = DB::select('select * from accounts where user_id = :user_id' ,  ['user_id' => $user_id]);
			$valid_account_ids = array();
			foreach($accounts as $account){
				$valid_id = $account->id;
				array_push($valid_account_ids, $valid_id);

			}
			$transactions = array();
			
			$allTransactions = DB::select('select * from transactions');

			foreach($allTransactions as $transaction){
				if(in_array($transaction->account_id, $valid_account_ids)){
					array_push($transactions, $transaction);
				}
			}
			$transactionManager = new TransactionManager();
			$transactions = $transactionManager -> sortTransactionsByDates($transactions);
			$transactions = array_reverse($tset);

			$assetsData = array();
			$liabilitiesData = array();
			foreach($transactions as $t){
				/*if date is before startDate, skip this transaction*/
				if($transactionManager->rawDateCompare($t->date, $startDate) > 0){
					continue;
				}
				/*if date is after endDate, skip this transaction*/
				if($transactionManager->rawDateCompare($t->date, $endDate) < 0){
					continue;
				}
				/*amount is greater than zero, therefore an asset*/
				if($t->amount > 0){
					if(!array_key_exists($t->date, $assetsData)){
						$assetsDate[$t->date] = 0;
					}
					$assetsData[$t->date] += $t->amount;
				}
				/*amount is less than zero, therefore a liability*/
				else{
					if(!array_key_exists($t->date, $liabilitiesData)){
						$liabilitiesDate[$t->date] = 0;
					}
					$liabilitiesData[$t->date] += -1 * $t->date;
				}
			}
			return 5;

			

		}
	}
}