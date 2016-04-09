<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

require_once 'app/Http/Controllers/BudgetController.php';
require_once 'app/Http/Controllers/AccountController.php'

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
        $otherSpending = sumCategoryTransaction(4, 'Other');
        $billSpending = sumCategoryTransaction(4, 'Bills');
        $loansSpending =  sumCategoryTransaction(4, 'Loans');
        $rentSpending =  sumCategoryTransaction(4, 'Rent');
        $foodSpending =  sumCategoryTransaction(4, 'Food');


        //these values will be fixed in sql for the test user
        $this -> assertEquals($otherSpending, 29, "Amount spent on Other expenses does not match sql transactions");
        $this -> assertEquals($billSpending, 13.54, "Amount spent on Bill expenses does not match sql transactions");
        $this -> assertEquals($loansSpending, 300, "Amount spent on Loans expenses does not match sql transactions");
        $this -> assertEquals($rentSpending, 27, "Amount spent on Rent expenses does not match sql transactions");
        $this -> assertEquals($foodSpending, 151.45, "Amount spent on Food expenses does not match sql transactions");

        */
 
        $this -> assertTrue(false);  //just for now
    }
}
