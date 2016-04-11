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

		if($request->ajax){
			return 5;
			/*$user = Session::get('user');
			$user_id = $user -> id;
			$accounts = DB::select('select * from accounts where user_id = :user_id' ,  ['user_id' => $user_id]);
			$valid_account_ids = array();
			foreach($accounts as $account){
				$valid_id = $account->id;
				array_push($valid_account_ids, $valid_id);

			}
			$transactions = array();
			
			$allTransactions = DB::select('select * from transactions');
			return json_encode(5);
			/*foreach($allTransactions as $transaction){
				if(in_array($transaction->id, $valid_account_ids){
					array_push($transactions, $transaction);
				}
			}
			return $transactions;*/

			

		}
	}
}