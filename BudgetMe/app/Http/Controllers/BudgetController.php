<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BudgetController extends Controller
{
	use DB;

    public function getBudgets(Request $request){
    	console.log("getBugdgets() called");
    	return "ok";
    }
}

