<?php


namespace App\Library;

class AccountManager{

	/*
		Parameters: Array of accounts

		Description: Sort the accounts array by name alphabetically

		Returns: Sorted array of accounts

		Created By: Rebbecca and Paul
	*/
    public function sortAccountsByNames($accounts){
		usort($accounts, function($lhs, $rhs)
		{
			return strcmp($lhs['name'], $rhs['name']);
		});

			
		return $accounts;
	}
}
?>