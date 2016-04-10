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

class GraphController extends Controller{
	public function populateGraph(Request $request){
		
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
	    foreach($tset as $t){
	    	//if cDate is before startDate, skip 
	    	if($tm->rawDateCompare($t['date'], $startDate) > 0)
	    		continue;
	    	//if date is after endDate, skip
	    	if($tm->rawDateCompare($t['date'], $endDate) < 0)
	    		continue;
	    	//transaction is in range, sum it to graphData
	    	if(!array_key_exists($t['date'], $graphData))
	    		$graphData[$t['date']] = 0;
	    	$graphData[$t['date']] += $t['amount'];
	    }
	    
	    var_dump($graphData);
	}

	public function test(){
		$this->getGraphDataForAnAccount("03/27/2014", "03/30/2016", 13);
	}
}