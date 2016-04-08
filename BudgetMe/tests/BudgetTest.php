<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\BudgetController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

require_once 'app/Http/Controllers/BudgetController.php';

class BudgetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function testgetBudgetLoggedInUser(){
    	
    	$this -> call('POST','/loadBudgets');
    	//$this -> call('POST','/loadBudgets');
    	//$this -> assertSessionHas('name');
    	$this -> assertResponseOk();
    	//$this -> assertSessionHas("password");
    	$this -> flushSession();
    }

    public function testupdateBudgetLoggedinUser(){
    	$this -> call('POST','/updateBudget');
    	$this -> assertResponseOk();
    	$this -> flushSession();
    }

    /*
    Parameters: None
    Description: calculate amount spent in each category can be pulled
    Return: Asserts if true or not
    Created By: Rebecca and Paul
    */
    public function testSpendingForEachCategoryCanBePulled(){
        $testUserName = "budgetTester@usc.edu"; //this user will have some set transaction spending that will never be changed so that this test will always pass

        /*
        //pull these with the function
        $otherSpending = //amount that this user spent in the "Other" category
        $billSpending = //amount user spent on bills
        $loansSpending =  //amount spent on loans 
        $rentSpending =  //ammount spent on rent
        $foodSpending =  // amount spent on food


        //these values will be fixed in sql for the test user
        $this -> assertEquals($otherSpending, 72.50, "Amount spent on Other expenses does not match sql transactions");
        $this -> assertEquals($billSpending, 81.50, "Amount spent on Bill expenses does not match sql transactions");
        $this -> assertEquals($loansSpending, 102.10, "Amount spent on Loans expenses does not match sql transactions");
        $this -> assertEquals($rentSpending, 100.00, "Amount spent on Rent expenses does not match sql transactions");
        $this -> assertEquals($otherSpending, 66.50, "Amount spent on Food expenses does not match sql transactions");

        */
 
        $this -> assertTrue(false);  //just for now
    }
}
