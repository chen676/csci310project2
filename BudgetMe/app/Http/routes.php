<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.

   This code was created by: Patrick and Brandon
   Edited by: Rebecca and Paul, Matt and Harshul (aka the rest of the team)
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('login');
    });

  	Route::post('/login', 'UserController@login');
  	Route::get('/dashboard', 'UserController@dashboard');
  	Route::get('/logout', 'UserController@logout');

  	Route::post('/remove_account', 'AccountController@removeAccount');
  	Route::post('/create_account', 'AccountController@addAccount');

  	Route::get('/budgetWidget',function()
	{
		return view('budgetWidget');
	});
  	//Route::post('/clickBudgetButton','BudgetController@getBudgets');

    Route::post('/loadBudgets','BudgetController@getBudgets');

    Route::post('/updateBudget', 'BudgetController@updateBudget');

    Route::post('/populateGraph', 'GraphController@populateGraph');

	Route::post('/display_transactions', 'UserController@getTransactionSet');
	Route::post('/display_graph', 'GraphController@getAccountSetForGraph');

	Route::get('/sort', 'GraphController@test');
	Route::post('/uploadCSV', 'AccountController@uploadCSV');
	Route::get('/viewT', 'UserController@getTransactionSet');

	Route::get('/clearList', 'UserController@clearList');
	Route::get('/sortTransactionSetByDate', 'UserController@sortTransactionSetByDate');
	Route::get('/sortTransactionSetByAmount', 'UserController@sortTransactionSetByAmount');
	Route::get('/sortTransactionSetByCategory', 'UserController@sortTransactionSetByCategory');
	Route::get('/csrf', function() {
    		return Session::token();
	});
});


