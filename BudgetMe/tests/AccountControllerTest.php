<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountControllerTest extends TestCase
{
    public function testAddAccount()
    {
    	$this
    		->visit('/')
    		->type('admin2@usc.edu', 'email')
    		->type('123456', 'password')
    		->press('Login')
    		->seePageIs('/dashboard')
    		->type('Test Account', 'name')
    		->press('Add Account')
    		->see('Test Account');
    }

    public function testRemoveAccount()
    {
    	$this
    		->visit('/')
    		->type('admin2@usc.edu', 'email')
    		->type('123456', 'password')
    		->press('Login')
    		->seePageIs('/dashboard')
    		->press('Delete Account')
    		->dontSee('Test Account');
    }
}
