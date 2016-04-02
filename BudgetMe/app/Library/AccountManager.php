<?php


namespace App\Library;

class AccountManager{

	//
    public function sortAccountsByNames($accounts){
		usort($accounts, function($lhs, $rhs)
		{
			return strcmp($lhs['name'], $rhs['name']);
		});

			
		return $accounts;
	}
}
?>