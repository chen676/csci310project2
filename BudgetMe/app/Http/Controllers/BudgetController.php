<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Budget;
use DB;
use Session;

class BudgetController extends Controller
{
    public function getBudgets(Request $request){
	   if($request->ajax())
	   {
	      $user = Session::get('user');

          $user_id = $user -> id;

          $user_budgets = DB::select('select * from budgets where user_id = :user_id', ['user_id' => $user_id]);
		  $user_list = DB::select('select * from users');
       		
       	//echo ($request['data']);

       	//return $users;

         return json_encode($user_budgets);
       }

    }
}

