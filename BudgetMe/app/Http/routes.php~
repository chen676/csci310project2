<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('login');
    });

  	Route::post('/login', 'UserController@login');
  	Route::get('/dashboard', 'UserController@dashboard');
  	Route::get('/logout', 'UserController@logout');
  	Route::get('/add_account', function()
  	{
  		return view('add_account');
  	});
  	Route::post('/create_account', 'AccountController@addAccount');


	Route::get('/sort', 'AccountController@sortAccounts');
	Route::get('/viewT', 'UserController@getTransactionSet');
});


