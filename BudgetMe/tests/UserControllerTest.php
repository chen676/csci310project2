<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    public function testLogin()
    {
    	$this
    		->visit('/')
    		->type('admin2@usc.edu', 'email')
    		->type('123456', 'password')
    		->press('Login')
    		->seePageIs('/dashboard');
    }

    public function testLogout()
    {
    	$this
    		->visit('/logout')
    		->seePageIs('/');
    }

    public function testDashboard()
    {
    	$this
    		->visit('/dashboard')
    		->seePageIs('/');
    }
}
