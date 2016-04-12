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

	/*
		Parameters: The start date (MM/DD/YYYY) that will correspond to the origin on the graph
					The end date (MM/DD/YYYY) that will correspond to the data point furthest from the origin in respect to the x-axis
					The id of the account for which the transactions will be gotten
		Description: This method will take in a specific account and a time range specified by the user in order to calculate the list of data points to be plotted on the main graph widget.
		Return: An Associative array with all the keys as dates and the values as the Account balance
		Created By: Rebecca + Paul 
	*/
	public function getGraphDataForAnAccount($startDate, $endDate, $acc_id){
		$result = Transaction::where('account_id', '=', $acc_id)->get();
		$tset = $result->toArray();
		$tm = new TransactionManager();
	    $tset = $tm -> sortTransactionsByDates($tset);
	    $tset = array_reverse($tset);

	    $graphData = array();
	    $cDate = $startDate;
	    $prevBalance = 0;
	    $transactionBeforeStartExists = false;

	    if(empty($tset))
	    	return array();
	    
	    foreach($tset as $t){
	    	//if cDate is before startDate, skip 
	    	if($tm->rawDateCompare($t['date'], $startDate) > 0) {
	    		$prevBalance += $t['amount'];
	    		$transactionBeforeStartExists = true;
	    		continue;
	    	}
	    	//if date is after endDate, skip
	    	if($tm->rawDateCompare($t['date'], $endDate) < 0)
	    		continue;
	    	//transaction is in range, sum it to graphData
	    	if(!array_key_exists($t['date'], $graphData))
	    		$graphData[$t['date']] = 0;
	    	$graphData[$t['date']] += $t['amount'];
	    }
	    
	    //cumulate each data point
	    $net = $prevBalance;
	    foreach($graphData as &$g){
	    	$net += $g;
	    	$g = $net;
	    }
	    //all data points betwen sDate and earliest transaction are $prevBalance
	    $paddingLeft = array();
	    $paddingRight = array();

	    if($transactionBeforeStartExists){
		    if(!array_key_exists($startDate, $graphData))
		    	$paddingLeft[$startDate] = $prevBalance;
		}
	    if(!array_key_exists($endDate, $graphData))
	    	$paddingRight[$endDate] = $net;	    

	  
	    //all points between latest transaction and fDate are $net
	    return array_merge($paddingLeft, $graphData, $paddingRight);
	}

	public function getAccountSetForGraph(Request $request){
 		if($request->ajax()){
			if($_POST['length'] == 0){
			  Session::put('checkedAccountsForGraph', array());
			  return;
			}

			$accountNames = $_POST['accountSet'];
			//need to create an array based on id, not name
			$user = Session::get('user');
			
			$graphData = array();

			foreach($accountNames as $name){
			  $account = Account::where('name', '=', $name)
			  ->where('user_id', '=', $user->id)
			  ->get()->first();
			  $aid = $account->id;
			  $data = $this->getGraphDataForAnAccount("02/27/2016", "03/30/2016", $aid);
			  $graphData[$name] = $data;
			}

			Session::put('checkedAccountsForGraph', $accountNames);
			return $graphData;
      	}		
	}
}