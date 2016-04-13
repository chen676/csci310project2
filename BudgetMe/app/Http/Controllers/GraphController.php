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

	/*
		Parameters: Request

		Description: Populates the default graph with assets and liabilities

		Returns:

		Created By: Matt and Harshul
	*/
	public function populateGraph(Request $request){

		if($request->ajax()){
			
			$user = Session::get('user');
			$user_id = $user -> id;
			$startDate = $request['starting_date'];
			$endDate = $request['ending_date'];
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
			$transactions = array_reverse($transactions);

			$prevBalanceAssets = 0;
			$prevBalanceLiabilities = 0;
			$transactionBeforeStartExistsAssets = false;
			$transactionBeforeStartExistsLiabilities = false;

			if(empty($transactions)){
				return array();
			}

			$assetsData = array();
			$liabilitiesData = array();
			foreach($transactions as $t){
				/*if date is before startDate, skip this transaction*/
				if($transactionManager->rawDateCompare($t->date, $startDate) > 0){
					if($t->amount > 0){
						$prevBalanceAssets += $t->amount;
						$transactionBeforeStartExistsAssets = true;
					}
					else{
						$prevBalanceAssets += -1 * $t->amount;
						$transactionBeforeStartExistsLiabilities = true;
					}
					continue;
				}
				/*if date is after endDate, skip this transaction*/
				if($transactionManager->rawDateCompare($t->date, $endDate) < 0){
					continue;
				}
				/*amount is greater than zero, therefore an asset*/
				if($t->amount > 0){
					if(!array_key_exists($t->date, $assetsData)){
						$assetsData[$t->date] = 0;
					}
					$assetsData[$t->date] += $t->amount;
				}
				/*amount is less than zero, therefore a liability*/
				else{
					if(!array_key_exists($t->date, $liabilitiesData)){
						$liabilitiesData[$t->date] = 0;
					}
					$liabilitiesData[$t->date] += -1 * $t->amount;
				}
			}
			//cumulate each data point for assets and liabilities
			$netAssets = $prevBalanceAssets;
			$netLiabilities = $prevBalanceLiabilities;
			foreach($assetsData as &$data){
				$netAssets += $data;
				$data = $netAssets;
			}

			foreach($liabilitiesData as &$data){
				$netLiabilities += $data;
				$data = $netLiabilities;
			}

			$paddingLeftAssets = array();
			$paddingRightAssets = array();

			$paddingLeftLiabilities = array();
			$paddingRightLiabilities = array();

			if($transactionBeforeStartExistsAssets){
				if(!array_key_exists($startDate, $assetsData)){
					$paddingLeftAssets[$startDate] = $prevBalanceAssets;
				}
			}
			if(!array_key_exists($endDate, $assetsData)){
				$paddingRightAssets[$endDate] = $netAssets;
			}

			$fullAssetsData = array_merge($paddingLeftAssets, $assetsData, $paddingRightAssets);

			if($transactionBeforeStartExistsLiabilities){
				if(!array_key_exists($startDate, $liabilitiesData)){
					$paddingLeftLiabilities[$startDate] = $prevBalanceLiabilities;
				}
			}
			if(!array_key_exists($endDate, $liabilitiesData)){
				$paddingRightLiabilities[$endDate] = $netLiabilities;
			}

			$fullLiabilitiesData = array_merge($paddingLeftLiabilities, $liabilitiesData, $paddingRightLiabilities);
			$totalData = array("Assets" => $fullAssetsData, "Liabilities" => $fullLiabilitiesData);

			
			return $totalData;

			


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

	/*
		Parameters: Request

		Description: get aggregate accounts to graph 

		Returns: associative array of accounts and balances for dates within the start and end

		Created By: Paul and Rebecca
	*/
	public function getAccountSetForGraph(Request $request){
 		if($request->ajax()){
			if($_POST['length'] == 0){
			  Session::put('checkedAccountsForGraph', array());
			  return;
			}

			$sDate = $_POST['sDate'];
			$eDate = $_POST['eDate'];
			if($sDate == "")
				$sDate = "01/01/1990";
			if($eDate == "")
				$eDate = "04/12/3000";

			$accountNames = $_POST['accountSet'];
			//need to create an array based on id, not name
			$user = Session::get('user');
			
			$graphData = array();

			foreach($accountNames as $name){
			  $account = Account::where('name', '=', $name)
			  ->where('user_id', '=', $user->id)
			  ->get()->first();
			  $aid = $account->id;
			  $data = $this->getGraphDataForAnAccount($sDate, $eDate, $aid);
			  $graphData[$name] = $data;
			}

			Session::put('checkedAccountsForGraph', $accountNames);
			return $graphData;
      	}		
	}
}