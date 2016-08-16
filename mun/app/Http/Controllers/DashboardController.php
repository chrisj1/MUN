<?php

namespace App\Http\Controllers;

use App\Committee;
use App\Lunch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Delegate;
use App\Money;
use App\Admin;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public static $price_per_delegate = 75.00;
    public static $registration_deadline;
    public static $registration_deadline_text;
    public static $max_delegates = 20;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        DashboardController::$registration_deadline = Carbon::createFromDate(2016,7,29);
        DashboardController::$registration_deadline_text = DashboardController::$registration_deadline->toFormattedDateString();
        $this->middleware('auth');
    }

    /**
     * Dashboard main page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user_id = Auth::id();
        if(Admin::where('user_id', '=', $user_id)->count() == 1) {
            return redirect('/dashboards/admin');
        }
        return view('dashboard.index');
    }

    public function manage()
    {
        $id = Auth::id();
        $user = Auth::user();
        $delegates = Delegate::where('user_id', '=', $id)->get();

        $delegate = new Delegate;


        $committees = Committee::all();

        $lunches = Lunch::all();

        $count = 1;

        return view('dashboard.manage', ['delegates' => $delegates, 'user' => $user,
            'delegate' => $delegate, 'committees' => $committees, 'lunches' => $lunches, 'count'=>$count]);
    }

    public function addDelegate(Request $request)
    {
        $time = Carbon::now();
        $pastRegistration = DashboardController::$registration_deadline->gte($time);

        if (count(Delegate::all()->where('user_id', '=', Auth::user()->id)) >= DashboardController::$max_delegates && $pastRegistration) {
            return back()->withErrors(['manage'=>'You have already registered the maximum of twenty delegates please wait
            until ' . DashboardController::$registration_deadline_text . ' to register more.']);
        }

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
        $id = Auth::id();
        $payments = DB::select('select * from payments where user_id = ?', [$id]);

	    $paid_amount = 0;
	    foreach($payments as $payment) {
	    	$paid_amount+=$payment->amount;
	    }
        $cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get());

        return view('dashboard.payment', ['paid' => $paid_amount, 'cost' => DashboardController::money_format('%#10n', $cost),
            'price_per_delegate' => DashboardController::money_format(
                '%#10n', DashboardController::$price_per_delegate),
            'amount_due' => DashboardController::money_format('%#10n', $cost - $paid_amount)]);
    }

    public function edit(Request $request, Delegate $delegate) {

        $id = Auth::id();
        $user = Auth::user();
        $delegates = Delegate::where('user_id', '=', $id)->get();

        $committees = Committee::all();

        $lunches = Lunch::all();

        return view('dashboard.edit', ['delegate'=>$delegate, 'delegates' => $delegates, 'user' => $user,
            'delegate' => $delegate, 'committees' => $committees, 'lunches' => $lunches]);
    }

    public function editDelegate(Request $request, Delegate $delegate) {
        $this->validate($request, [
            'firstname' => 'required|AlphaNum',
            'lastname' => 'required|AlphaNum',
        ]);

        $delegate->firstname = $request->firstname;
        $delegate->lastname = $request->lastname;
        $delegate->requested_committee = $request->requested_committee;
        $delegate->lunch = $request->lunch;
        $delegate->save();
        return back();
    }



    public static function money_format($format, $number)
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = '';
            }
            $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }
}