<?php

namespace App\Library;

class TransactionManager{

    public function sortTransactionsByDates($transactionSet){
		usort($transactionSet, array($this, "dateComparator"));	
		return $transactionSet;
	}


	public function dateComparator($lhs, $rhs) //compare two transactions by date
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
    }

	public function sortTransactionsByCategory($transactionSet){
		usort($transactionSet, function($lhs, $rhs)
		{
			return strcmp($lhs['category'], $rhs['category']);
		});
		return $transactionSet;
	}

	public function sortTransactionsByAmount($transactionSet){
		usort($transactionSet, function($lhs, $rhs)
		{
			return $lhs['amount'] < $rhs['amount'];
		});
		return $transactionSet;
	}


}
?>