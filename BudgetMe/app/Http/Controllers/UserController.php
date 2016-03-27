<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
    	$user = User::where('email', '=', $request->input('email'))
    	->where('password', '=', $request->input('password')
    	->get();

    	if ($user)
    	{
    		return view('dashboard');
    	}

    	//user info is incorrect, display errors
    	return redirect('login')->with('success', false);
    }
}
