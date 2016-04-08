<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Budget;
use DB;
use Session;

class BudgetController extends Controller
{

    /*
        Parameters: Route Request

        Description: Retrieve a specific user's budgets from the MySQL database

        Returns: JSON string of all budgets

        Created By:
    */
    public function getBudgets(Request $request){
	   if($request->ajax())
	   {
	      $user = Session::get('user');

          $user_id = $user -> id;

          $user_budgets = DB::select('select * from budgets where user_id = :user_id', ['user_id' => $user_id]);
		      //$user_list = DB::select('select * from users');
       		
       	//echo ($request['data']);

       	//return $users;

         return json_encode($user_budgets);
       }

    }
    /*
        Parameters: Route Request

        Description: Update a budget based off the inputted values from the user

        Returns: JSON string of the updated budgets

        Created By:
    */
    public function updateBudget(Request $request){
      if($request->ajax()){
        $user = Session::get('user');
        $user_id = $user -> id;
        $updated_amount = $request['updated_amount'];
        $category = $request['category'];
        DB::update('update budgets set amount = :updated_amount where user_id = :user_id and category = :category', ['updated_amount' => $updated_amount, 'user_id' => $user_id, 'category' => $category ]);
        return json_encode($updated_amount);


      }
    }

    /*
        Parameters: The name of the category to get the spending for

        Description: Calculates the amount spent in this category across all accounts

        Returns: The amount spent for this category across all accounts
        
        Created By: Rebecca and Paul
    */
    public function getSpendingForCategory($categoryName){
      
    }

}

