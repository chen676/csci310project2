<?php

namespace App\Library;

class CSVManager{

	public function __construct(){

	}
	
	/*
		Parameters: Browsed file path + extension

		Description: Uploads the inputted file and parses the CSV for new transactions

		Returns: 2D array of transactions

		Created By: Brandon/Patrick
	*/
	public function parseCSV($target_file){

		$transactions = array();

		$file = fopen($target_file,"r");
		$header = fgetcsv($file);
		while($row = fgetcsv($file)){

			// format: CATEGORY (STRING), AMOUNT (INT), MERCHANT (STRING), DATE (STRING)
			$single_transaction = array($row[0], round(floatval($row[1]), 2, PHP_ROUND_HALF_UP), $row[2], $row[3]);
			$transactions[] = $single_transaction;
		}
		fclose($file);

		/* debugging echos
		foreach($transactions as $single){
			echo "CATEGORY=" . $single[0] . ", AMOUNT=" . $single[1] . ", MERCHANT=" . $single[2] . ", DATE=" . $single[3];
			echo "<br>";
		}
		*/

		/* OVERALL FORMAT OF TRANSACTIONS MULTIDIMENSIONAL ARRAY

			Food | 300 | Ralph's | 11/12/1996
			Bills | 1000 | USC | 12/03/2005

			transactions[0] would return the entire first array
			transactions[0][2] would return "Ralph's"
			transactions[1][1] would return 1000

		*/
		return $transactions;
	}
}
?>