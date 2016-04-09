<?php

namespace App\Library;

class TransactionManager{

	/*
		Parameters: Array of transactions

		Description: Sorts inputted transactions array by date chronologically

		Returns: Sorted array of transactions

		Created By:  
	*/
    public function sortTransactionsByDates($transactionSet){
		usort($transactionSet, array($this, "dateComparator"));	
		return $transactionSet;
	}

	/*
		Parameters: Two different transactions

		Description: Comparator for comparing two transactions

		Returns: -1 or 1 depending on if the left transaction happened earlier or later

		Created By:
	*/
	public function dateComparator($lhs, $rhs){

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

    /*
		Parameters: Array of transactions

		Description: Sorts inputted transactions array by category alphabetically

		Returns: Sorted array of transactions

		Created By:  
	*/
	public function sortTransactionsByCategory($transactionSet){

		usort($transactionSet, function($lhs, $rhs)
		{
			return strcmp($lhs['category'], $rhs['category']);
		});
		return $transactionSet;
	}

	/*
		Parameters: Array of transactions

		Description: Sorts inputted transactions array by amount from least to greatest

		Returns: Sorted array of transactions

		Created By:  
	*/
	public function sortTransactionsByAmount($transactionSet){
		
		usort($transactionSet, function($lhs, $rhs)
		{
			return $lhs['amount'] < $rhs['amount'];
		});
		return $transactionSet;
	}


}
?>