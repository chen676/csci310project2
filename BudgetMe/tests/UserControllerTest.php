<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

class UserControllerTest extends TestCase
{

     /*
        Parameters: None

        Description: Test if a valid login can occur

        Returns: None

        Created By: Brandon and Patrick
    */
    
    public function testLoginWithCorrectInfo()
    {
    	$this
    		->visit('/')
    		->type('admin2@usc.edu', 'email')
    		->type('123456', 'password')
    		->press('Login')
    		->seePageIs('/dashboard');
    }
    

    /*
        Parameters: None

        Description: Test if a invalid login can occur

        Returns: None

        Created By: Brandon and Patrick
    */

    public function testLoginWithIncorrectInfo()
    {
    	$this
    		->visit('/')
    		->type('wrong_email', 'email')
    		->type('wrong_password', 'password')
    		->press('Login')
    		->see('Email or password is incorrect. Please try again.');
    }

    /*
        Parameters: None

        Description: Test if a valid logout can occur

        Returns: None

        Created By: Brandon and Patrick
    */
    public function testLogout()
    {
    	$this
    		->visit('/logout')
    		->seePageIs('/');
    }

    /*
        Parameters: None

        Description: Test if a dashboard can be visited without logging in

        Returns: None

        Created By: Brandon and Patrick
    */
    public function testDashboard()
    {
    	$this
    		->visit('/dashboard')
    		->seePageIs('/');
    }

    /*
        Parameters: None

        Description: Test that the password stored in SQL is not plain text, but the encrypted version of the password.

        Returns: None

        Created By: Brandon and Patrick
    */
    public function testEncryption()
    {
        $user = User::find(1);

        $this->assertNotEquals('123456', $user->password);
    }
}
