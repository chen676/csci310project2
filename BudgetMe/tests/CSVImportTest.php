<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

require_once 'app/Library/CSVManager.php';

class CSVImportTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return 2D Array of Transactions
     */
    public function testParseCSVOnTest1CSV()
    {
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
    	$this->assertEquals(1000.0, $transactions[0][1]);
    	$this->assertEquals("Ralphs", $transactions[0][2]);
    	$this->assertEquals("11/11/2016", $transactions[0][3]);
    	// row 2
    	$this->assertEquals("Loans", $transactions[1][0]);
    	$this->assertEquals(100.0, $transactions[1][1]);
    	$this->assertEquals("USC", $transactions[1][2]);
    	$this->assertEquals("11/11/2015", $transactions[1][3]);
    }

}
