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
    		->type('user6@gmail.com', 'email')
    		->type('password', 'password')
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
    		->type('user6@gmail.com', 'email')
    		->type('password', 'password')
    		->press('Login')
    		->seePageIs('/dashboard')
    		->press('Delete Account')
    		->dontSee('Test Account');
    }
}
