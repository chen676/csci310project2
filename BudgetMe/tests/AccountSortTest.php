<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Library\AccountManager;

require_once 'app/Library/AccountManager.php';

class AccountSortTest extends TestCase
{
    /**
     * Test whether or not accounts are sorted by name
     */
    public function testAccountsCanBeSortedAlphabeticallyByName()
    {
    	// Setup

        //create sample list of accounts
        $account1 = array();
        $account1['name'] = "John";
        $account2 = array();
        $account2['name'] = "Mary";
        $account3 = array();
        $account3['name'] = "Andy";
        $account4 = array();
        $account4['name'] = "Sylas";
        $account5 = array();
        $account5['name'] = "Allison";

        $accountList = array($account1, $account2, $account3, $account4, $account5);


    	$accountManager = new AccountManager(); 
    	
    	//Arrange
    	$accounts = $accountManager->sortAccountsByNames($accountList); //call the function

        //now loop through the array of accounts and make sure that it is sorted
        $sortedCorrectly = 1; //true if sorted

        //get the first account name of the array
        reset($accounts);
        $firstElement = current($accounts);
        $firstName = (string) $firstElement['name']; 

        foreach($accounts as $acc)
        {
            $nextName = (string) $acc['name'];

            //the first string is lexicographically "greater" than the next one, which is wrong
            if( strcasecmp($firstName, $nextName) > 0){ 
                $sortedCorrectly = 0; //sorted correctly is false
                break; //break out of the for loop
            }
            else{ //firstName and nextName are in correct order
                $firstName = $nextName;
            }
        }

    	// Assert
    	$this->assertEquals($sortedCorrectly, 1, "Sorting accounts alphabetically by name does not work"); //assert that it is correctly sorted
    }

}
