<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

require_once 'app/Library/CSVManager.php';

use App\Library\CSVManager;



class CSVImportTest extends TestCase
{
    /*
        Parameters: None

        Description: Test if first sample csv can be parsed correctly

        Returns: None

        Created By: Brandon and Patrick
    */
    public function testParseCSVOnTest1CSV(){

    	// Arrange
    	$csvm = new CSVManager();
    	
    	/*
    	$response = $this->action('GET', 'AccountController@parseCSV', ["parameter" => "tests_resources/test1.csv"]);
    	*/
		
    	// Act
    	$transactions = $csvm->parseCSV('tests_resources/test1.csv');

 
    	// Assert
    	// row 1
    	$this->assertEquals("Food", $transactions[0][0]);
    	$this->assertEquals(-1000.0, $transactions[0][1]);
    	$this->assertEquals("Ralphs", $transactions[0][2]);
    	$this->assertEquals("11/11/2016", $transactions[0][3]);
    	// row 2
    	$this->assertEquals("Loans", $transactions[1][0]);
    	$this->assertEquals(-100.0, $transactions[1][1]);
    	$this->assertEquals("USC", $transactions[1][2]);
    	$this->assertEquals("11/11/2015", $transactions[1][3]);
        // row 3
        $this->assertEquals("Other", $transactions[2][0]);
        $this->assertEquals(300.0, $transactions[2][1]);
        $this->assertEquals("Bank of America", $transactions[2][2]);
        $this->assertEquals("11/12/1996", $transactions[2][3]);
    }

    /*
        Parameters: None

        Description: Test if second sample csv can be parsed correctly and can correctly round transaction amount to 2 decimal places

        Returns: None

        Created By: Brandon and Patrick
    */
    public function testParseCSVOnTest2CSVRoundTwoDecimalPlaces(){

        // Arrange
        $csvm = new CSVManager();

        // Act
        $transactions = $csvm->parseCSV('tests_resources/test2.csv');

        //Assert
        // row 1
        $this->assertEquals("Food", $transactions[0][0]);
        $this->assertEquals(-1000.36, $transactions[0][1]);
        $this->assertEquals("Ralphs", $transactions[0][2]);
        $this->assertEquals("11/21/2015", $transactions[0][3]);
        // row 2
        $this->assertEquals("Other", $transactions[1][0]);
        $this->assertEquals(300.30, $transactions[1][1]);
        $this->assertEquals("USC", $transactions[1][2]);
        $this->assertEquals("12/12/2015", $transactions[1][3]);

    }

}
