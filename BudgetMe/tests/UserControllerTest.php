<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    public function testLoginWithCorrectInfo()
    {
    	$this
    		->visit('/')
    		->type('admin2@usc.edu', 'email')
    		->type('123456', 'password')
    		->press('Login')
    		->seePageIs('/dashboard');
    }

    public function testLoginWithIncorrectInfo()
    {
    	$this
    		->visit('/')
    		->type('wrong_email', 'email')
    		->type('wrong_password', 'password')
    		->press('Login')
    		->see('Email or password is incorrect. Please try again.');
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
