<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

require_once 'app/Http/Controllers/BudgetController.php';

class BudgetTest extends TestCase
{
	/*
        Parameters: None

        Description: Test if budgets for current month is first displayed

        Returns: Asserts if true or not

        Created By: Patrick and Harshul
    */
	public function testgetBudgetStartsWithCurrentMonth(){
		/*ToDo*/
		$this
            ->visit('/')
            ->type('admin2@usc.edu', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/dashboard')
            ->select('April','monthSelector');
	}

    public function testGetAllPossibleMonths(){
        $this
            ->visit('/')
            ->type('admin2@usc.edu', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/dashboard')
            ->select('February','monthSelector')
            ->select('March','monthSelector')
            ->select('April','monthSelector');

    }

	
    /*
        Parameters: None

        Description: Test if budgets for a user can be pulled from database

        Returns: None

        Created By: Matt and Harshul
    */
    public function testgetBudgetLoggedInUser(){
    	
    	$this -> call('POST','/loadBudgets');
    	//$this -> call('POST','/loadBudgets');
    	//$this -> assertSessionHas('name');
    	$this -> assertResponseOk();
    	//$this -> assertSessionHas("password");
    	$this -> flushSession();
    }

    /*
        Parameters: None

        Description: Test if budgets for a user can be updated to database

        Returns: None

        Created By: Matt and Harshul
    */
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


        $budgetController = new BudgetController();

        //pull these with the function
        $otherSpending = $budgetController -> sumCategoryTransaction(4, 'Other', 'March');
        $billSpending = $budgetController -> sumCategoryTransaction(4, 'Bills', 'March');
        $loansSpending =  $budgetController -> sumCategoryTransaction(4, 'Loans', 'March');
        $rentSpending =  $budgetController -> sumCategoryTransaction(4, 'Rent', 'March');
        $foodSpending =  $budgetController -> sumCategoryTransaction(4, 'Food', 'March');


        //these values will be fixed in sql for the test user
        $this -> assertEquals($otherSpending, 34.10, "Amount spent on Other expenses does not match sql transactions");
        $this -> assertEquals($billSpending, 13.54, "Amount spent on Bill expenses does not match sql transactions");
        $this -> assertEquals($loansSpending, 300, "Amount spent on Loans expenses does not match sql transactions");
        $this -> assertEquals($rentSpending, 27, "Amount spent on Rent expenses does not match sql transactions");
        $this -> assertEquals($foodSpending, 151.45, "Amount spent on Food expenses does not match sql transactions");

    }
}
