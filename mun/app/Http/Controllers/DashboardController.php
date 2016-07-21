<?php

namespace App\Http\Controllers;

use App\Committee;
use App\Lunch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Delegate;

class DashboardController extends Controller
{
    public static $price_per_delegate = 7500;

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

        $delegate = new Delegate;


        $committees = Committee::all();

        $lunches = Lunch::all();

        return view('dashboard.manage', ['delegates' => $delegates, 'user' => $user,
            'delegate' => $delegate, 'committees' => $committees, 'lunches'=> $lunches]);
    }

    public function addDelegate(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|AlphaNum',
            'lastname' => 'required|AlphaNum',
        ]);

        $delegate = new Delegate;
        $delegate->firstname = $request->firstname;
        $delegate->lastname = $request->lastname;
        $delegate->requested_committee = $request->requested_committee;
        $delegate->lunch = $request->lunch;
        $delegate->user_id = Auth::user()->id;
        $delegate->save();
        return back();

    }
    
    public function payment()
    {
        $user = Auth::user();
        $paid = $user->amount_payed;
        $amount_due = DashboardController::$price_per_delegate * count(Delegate::all()->where('user_id', '=', $user->id));
        return view('dashboard.payment', ['paid'=>$paid, 'amount_due'=>$amount_due, 'price_per_delegate'=> money_format('%i', DashboardController::$price_per_delegate)]);
    }
    

}
