<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
    	$user = User::with('accounts', 'budgets')
    	->where('email', '=', $request->input('email'))
    	->where('password', '=', $request->input('password'))
    	->get();

    	if (count($user) == 1)
    	{
    		return view('dashboard', [
    			'user' => $user
    		]);
    	}

    	//user info is incorrect, display errors
    	return redirect('/')->with('loginErrors', true);
    }
}
