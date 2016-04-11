<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Budget;
use Session;

use App\Library\TransactionManager;

class GraphController extends Controller{
	public function populateGraph(Request $request){
		if($request->ajax){
			$user = Session::get('user');
			$user_id = $user -> id;
			$user_transactions = DB::select('select * from transactions where user_id = :user_id' ,  ['user_id' => $user_id]);
		}
	}
}