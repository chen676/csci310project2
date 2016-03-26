<?php
 
	//session_start();
	
	uploadCSVToServer();
​
	function uploadCSVToServer(){

		// FILEPATH BELOW TO CHANGE
		readfile("http://localhost/Frontend/dashboard.html");
		//modified code from http://www.w3schools.com/php/php_file_upload.asp
		$target_dir = "";

		// FILENAME MIGHT CHANGE BELOW
		$target_file = $target_dir . "temp.csv";
		$uploadOk = 1;
		$imageFileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			//echo "Sorry, your file is too large.";
			$message =  "Sorry, your file is too large.";
			echo "<script type='text/javascript'>alert('$message');</script>";
			$uploadOk = 0;
		}
		// Allow only CSV files
		if($imageFileType != "csv") {
			//echo "Sorry, only CSV files are allowed.";
			$message =  "Sorry, only CSV files are allowed.";
			echo "<script type='text/javascript'>alert('$message');</script>";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			//echo "Sorry, your file was not uploaded.";
			
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				$message =  "Portfolio imported sucessfully!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				parseCSVToArrays($target_file);
			} else {
				$message = "Sorry, there was an error uploading your file.";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		
	}
	// parse the csv file for values
	function parseCSVToArrays($target_file){

		$transactions = array();

		$file = fopen($target_file,"r");
		$header = fgetcsv($file);
		while($row = fgetcsv($file)){

			// format: CATEGORY (STRING), AMOUNT (INT), MERCHANT (STRING), DATE (STRING)
			$single_transaction = array($row[0], intval($row[1]), $row[2], $row[3]);
			$transactions[] = $single_transaction;
		}
		fclose($file);

		foreach($transactions as $single){
			echo "CATEGORY=" . $single[0] . ", AMOUNT=" . $single[1] . ", MERCHANT=" . $single[2] . ", DATE=" . $single[3];
			echo "<br>";
		}

		/* OVERALL FORMAT OF TRANSACTIONS MULTIDIMENSIONAL ARRAY

			FOOD | 300 | RALPHS | 11/12/1996
			BILLS | 1000 | USC | 12/03/2005

			transactions[0] would return the entire first array
			transactions[0][2] would return "RALPHS"
			transactions[1][1] would return 1000

		*/

		return $transactions;
	}
	
?>