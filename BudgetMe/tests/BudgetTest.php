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
}
