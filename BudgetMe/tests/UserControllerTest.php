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
    		->type('user1@gmail.com', 'email')
    		->type('password', 'password')
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
