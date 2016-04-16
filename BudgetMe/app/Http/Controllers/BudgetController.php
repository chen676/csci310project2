<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Transaction;
use App\Http\Requests;
use App\Models\Budget;
use DB;
use Session;

class BudgetController extends Controller
{

    public function __construct(){

    }
    
    /*
        Parameters: Route Request

        Description: Retrieve a specific user's budgets from the MySQL database

        Returns: JSON string of all budgets

        Created By: Matt and Harshul
    */
    public function getBudgets(Request $request){
	   if($request->ajax()){
	   
	      $user = Session::get('user');

        $user_id = $user -> id;

        $user_budgets = DB::select('select * from budgets where user_id = :user_id', ['user_id' => $user_id]);
		    //$user_list = DB::select('select * from users');
       		
       	//echo ($request['data']);

       	//return $users;

        $categoryColors = ["Other" => "Green",
                           "Bills" => "Green",
                           "Loans" => "Green",  
                           "Rent" => "Green",
                           "Food" => "Green"];
        foreach($user_budgets as $budget){
          $categoryColors[$budget->category] = $this->getColorForBudgetTransactions($budget->category, $budget->amount);
        }

        $returnVal = ['budgetData' => $user_budgets,
                      'colorData' => $categoryColors];
        return json_encode($returnVal);
       }

    }
    /*
        Parameters: Route Request

        Description: Update a budget based off the inputted values from the user

        Returns: JSON string of the updated budgets

        Created By: Matt and Harshul
    */
    public function updateBudget(Request $request){
      if($request->ajax()){
        $user = Session::get('user');
        $user_id = $user -> id;
        $updated_amount = $request['updated_amount'];
        $category = $request['category'];
        DB::update('update budgets set amount = :updated_amount where user_id = :user_id and category = :category', ['updated_amount' => $updated_amount, 'user_id' => $user_id, 'category' => $category ]);
        //get potential new color

        $newColor = $this->getColorForBudgetTransactions($category, $updated_amount);
        $returnVal = ["data" => $updated_amount, "color" => $newColor];
        return json_encode($returnVal);
      }
    }


    /*
        Parameters: The name of the category to get the spending for
                    The current amount set by the user for the budget category
        Description: Determines the color to show the budget value as

        Returns: The color that should be displayed; green, yellow, or red
        
        Created By: Rebecca and Paul
    */
    public function getColorForBudgetTransactions($categoryName, $currentBudget){
        $user = Session::get('user');
        $user_id = $user -> id;  
        $sum = $this->sumCategoryTransaction($user_id, $categoryName);
        if($sum > $currentBudget)
          return "Red";
        else if($sum == $currentBudget)
          return "Yellow";
        else
          return "Green";
    }

    /*
        param: category is a string that represents which category of transactions to sum
        description: This method will sum all of the spending transactions
          symbolized by a negative amount, and then return the absolute value
          of it regarding a specific category
        return: returns a float, the total sum of transactions
        written by: Rebecca/Paul
    */
    public function sumCategoryTransaction($id, $cat){
        //need to build a list of all accounts tied to the user
        $sum = 0.00;
        $accounts = Account::where('user_id', '=', $id)->get();
        $transSet = array();
        foreach($accounts as $acc){
            $transactions = Transaction::where('category', '=', $cat)
            ->where('account_id', '=', $acc['id'])->get();

            foreach($transactions as $trans){
                if($trans['amount'] <= 0) //only negative numbers count as spending
                  $sum += $trans['amount'];
            }
        }
        $sum = round( $sum, 2, PHP_ROUND_HALF_UP);
        return -1 * $sum;
    }
}

