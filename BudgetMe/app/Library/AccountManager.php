<?php


class AccountManager{

	//
    public function sortAccountsByNames($accounts){
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
}
?>