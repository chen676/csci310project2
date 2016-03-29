<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class BudgetController extends Controller
{
    public function getBudgets(Request $request){
    	console.log("getBugdgets() called");
    	return "ok";
    }
}

