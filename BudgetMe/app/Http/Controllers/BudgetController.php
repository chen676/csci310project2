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
		   //$users = DB::select('select * from users');
       		
       	//echo ($request['data']);

       	//return $users;

         return "hi";
       }

    }
}

