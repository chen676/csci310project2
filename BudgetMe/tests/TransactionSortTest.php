<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Library\TransactionManager;

require_once 'app/Library/TransactionManager.php';

class TransactionSortTest extends TestCase
{
    public function testTransactionsCanBeSortedByAmount(){
        // Setup

        //create sample list of accounts
        $transaction1 = array();
        $transaction1['amount'] = 11.20;
        $transaction2 = array();
        $transaction2['amount'] = -11.50;
        $transaction3 = array();
        $transaction3['amount'] = 12.12;
        $transaction4 = array();
        $transaction4['amount'] = 13.12;
        $transaction5 = array();
        $transaction5['amount'] = -0.50;

        $transactionList = array($transaction1, $transaction2, $transaction3, $transaction4, $transaction5);


        $transactionManager = new TransactionManager(); 
        
        //Arrange
        $transactions = $transactionManager->sortTransactionsByAmount($transactionList); //call the function

        //now loop through the array of accounts and make sure that it is sorted
        $sortedCorrectly = 1; //true if sorted

        //get the first transaction category of the array
        reset($transactions);
        $firstElement = current($transactions);
        $firstAmount = (string) $firstElement['amount']; 

        foreach($transactions as $acc)
        {
            $nextAmount = (string) $acc['amount'];

            //the first transaction costed less than next one, which is INCORRECT
            if( $firstAmount < $nextAmount){ 
                $sortedCorrectly = 0; //sorted correctly is false
                break; //break out of the for loop
            }
            else{ //firstCategory and nextCategory are in correct order
                $firstAmount = $nextAmount;
            }
        }

        // Assert
        $this->assertEquals($sortedCorrectly, 1, "Sorting transactions by amount does not work"); //assert that it is correctly sorted

    }
    public function testTransactionsCanBeSortedByCategory(){
        // Setup

        //create sample list of accounts
        $transaction1 = array();
        $transaction1['category'] = "Food";
        $transaction2 = array();
        $transaction2['category'] = "Rent";
        $transaction3 = array();
        $transaction3['category'] = "Entertainment";
        $transaction4 = array();
        $transaction4['category'] = "Other";
        $transaction5 = array();
        $transaction5['category'] = "Alcatraz";

        $transactionList = array($transaction1, $transaction2, $transaction3, $transaction4, $transaction5);


        $transactionManager = new TransactionManager(); 
        
        //Arrange
        $transactions = $transactionManager->sortTransactionsByCategory($transactionList); //call the function

        //now loop through the array of accounts and make sure that it is sorted
        $sortedCorrectly = 1; //true if sorted

        //get the first transaction category of the array
        reset($transactions);
        $firstElement = current($transactions);
        $firstCategory = (string) $firstElement['category']; 

        foreach($transactions as $acc)
        {
            $nextCategory = (string) $acc['category'];

            //the first string is lexicographically "greater" than the next one, which is wrong
            if( strcasecmp($firstCategory, $nextCategory) > 0){ 
                $sortedCorrectly = 0; //sorted correctly is false
                break; //break out of the for loop
            }
            else{ //firstCategory and nextCategory are in correct order
                $firstCategory = $nextCategory;
            }
        }

        // Assert
        $this->assertEquals($sortedCorrectly, 1, "Sorting transactions by category does not work"); //assert that it is correctly sorted
    }
    /**
     * Test whether or not accounts are sorted by name
     */
    public function testTransactionsCanBeSortedByDate()
    {
    	// Setup

        //create sample list of accounts
        $transaction1 = array();
        $transaction1['date'] = "01/12/2016";
        $transaction2 = array();
        $transaction2['date'] = "02/22/2016";
        $transaction3 = array();
        $transaction3['date'] = "02/23/2016";
        $transaction4 = array();
        $transaction4['date'] = "01/12/2005";
        $transaction5 = array();
        $transaction5['date'] = "12/7/2015";

        $transactionList = array($transaction1, $transaction2, $transaction3, $transaction4, $transaction5);


    	$transactionManager = new TransactionManager(); 
    	
    	//Arrange
    	$transactions = $transactionManager->sortTransactionsByDates($transactionList); //call the function

        //now loop through the array of accounts and make sure that it is sorted
        $sortedCorrectly = 1; //true if sorted

        //get the first transaction of the array
        reset($transactions);
        $firstTransaction = current($transactions);

        foreach($transactions as $acc)
        {
            $nextTransaction = $acc;

            //the first date is less recent than the next one, which is wrong
            if( $transactionManager->dateComparator($firstTransaction, $nextTransaction) == 1){ 
                $sortedCorrectly = 0; //sorted correctly is false
                break; //break out of the for loop
            }
            else{ //first and next are in correct order
                $firstTransaction = $nextTransaction;
            }
        }

    	// Assert
    	$this->assertEquals($sortedCorrectly, 1, "Sorting transactions by date does not work"); //assert that it is correctly sorted
    }

}
