<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Delegate;

class DashboardController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
    	return view('dashboard.index');
    }

    public function manage() {
        $id = Auth::id();
        $user = Auth::user();
    	$delegates = Delegate::where('user_id', '=', $id)->get();
        return view('dashboard.manage', ['delegates' => $delegates, 'user' => $user]);
    }
}
