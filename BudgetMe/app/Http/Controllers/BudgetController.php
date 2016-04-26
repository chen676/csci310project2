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

        Edited by Matt and Rebecca
    */
    public function getBudgets(Request $request){
	   if($request->ajax()){
	   
	      $user = Session::get('user');

        $user_id = $user -> id;

        $month = $_POST['month'];

        $user_budgets = DB::select('select * from budgets where user_id = :user_id and month = :month', ['user_id' => $user_id, 'month' => $month]);

        $categoryColors = ["Other" => "Green",
                           "Bills" => "Green",
                           "Loans" => "Green",  
                           "Rent" => "Green",
                           "Food" => "Green"];
        foreach($user_budgets as $budget){
          $categoryColors[$budget->category] = $this->getColorForBudgetTransactions($budget->category, $budget->amount, $month);
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
        $month = $request['month'];
        DB::update('update budgets set amount = :updated_amount where user_id = :user_id and category = :category and month = :month', ['updated_amount' => $updated_amount, 'user_id' => $user_id, 'category' => $category, 'month' => $month ]);
        //get potential new color

        $newColor = $this->getColorForBudgetTransactions($category, $updated_amount, $month);
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
    public function getColorForBudgetTransactions($categoryName, $currentBudget, $budgetMonth){
        $user = Session::get('user');
        $user_id = $user -> id;  
        $sum = $this->sumCategoryTransaction($user_id, $categoryName, $budgetMonth);
        if($sum > $currentBudget)
          return "R" . $sum;
        else if($sum == $currentBudget)
          return "Y" . $sum;
        else
          return "G" . $sum;
    }

    /*
        param: category is a string that represents which category of transactions to sum
        description: This method will sum all of the spending transactions
          symbolized by a negative amount, and then return the absolute value
          of it regarding a specific category
        return: returns a float, the total sum of transactions
        written by: Rebecca/Paul
    */
    public function sumCategoryTransaction($id, $cat, $budgetMonth){
        //need to build a list of all accounts tied to the user
        $sum = 0.00;
        $accounts = Account::where('user_id', '=', $id)->get();
        $transSet = array();
        foreach($accounts as $acc){
            $transactions = Transaction::where('category', '=', $cat)
            ->where('account_id', '=', $acc['id'])->get();

            foreach($transactions as $trans){
                if($trans['amount'] <= 0){ //only negative numbers count as spending
                    $date = $trans['date'];
                    $newDate = explode('/', $date);
                    $budgetNewDate = '0';
                    if($budgetMonth == 'January')
                        $budgetNewDate = '01';
                    if($budgetMonth == 'February')
                        $budgetNewDate = '02';
                    if($budgetMonth == 'March')
                        $budgetNewDate = '03';
                    if($budgetMonth == 'April')
                        $budgetNewDate = '04';
                    if($budgetMonth == 'May')
                        $budgetNewDate = '05';
                    if($budgetMonth == 'June')
                        $budgetNewDate = '06';
                    if($budgetMonth == 'July')
                        $budgetNewDate = '07';
                    if($budgetMonth == 'August')
                        $budgetNewDate = '08';
                    if($budgetMonth == 'September')
                        $budgetNewDate = '09';
                    if($budgetMonth == 'October')
                        $budgetNewDate = '10';
                    if($budgetMonth == 'November')
                        $budgetNewDate = '11';
                    if($budgetMonth == 'December')
                        $budgetNewDate = '12';
                    if($newDate[0] == $budgetNewDate){
                        $sum += $trans['amount'];
                    }
                }
            }
        }
        $sum = round( $sum, 2, PHP_ROUND_HALF_UP);
        if($sum != 0)
            $sum = -1 * $sum;
        return $sum;
    }
}

