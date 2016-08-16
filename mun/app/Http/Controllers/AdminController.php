<?php

namespace App\Http\Controllers;

use App\Admin;
use App\position;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Committee;
use App\Lunch;
use App\User;
use App\Delegate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
	/**
	 * AdminController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('isAdmin');
	}

	/**
	 * Returns the main dashboard page for admins
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$delegates = Delegate::all();
		$users = User::all();
		$lunches = Lunch::all();
		$committees = Committee::all();

		return view('dashboard.admin.index', ['delegates' => $delegates, 'users' => $users, 'lunches' => $lunches, 'committees' => $committees]);
	}

	/**
	 * Returns the delegates dashboard page for admins
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delegates()
	{
		$delegates = Delegate::all();
		$users = User::all();
		$lunches = Lunch::all();
		$committees = Committee::all();
		$count = 0;

		return view('dashboard.admin.delegates', ['delegates' => $delegates, 'users' => $users, 'lunches' => $lunches, 'committees' => $committees, 'count' => $count]);
	}

	/**
	 * Returns the main dashboard page for admins
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function lunches()
	{
		$delegates = Delegate::all();
		$users = User::all();
		$lunches = Lunch::all();
		$committees = Committee::all();

		return view('dashboard.admin.lunches', ['delegates' => $delegates,
			'users' => $users, 'lunches' => $lunches, 'committees' => $committees]);
	}

	public function delegations()
	{
		$users = User::all();
		$delegations = new Collection();
		$delegates = Delegate::all();

		foreach ($users as $user) {
			$user_id = $user->id;
			if (count(Admin::where('user_id', $user_id)->get()) != 1) {
				$delegations->add($user);
			}
		}
		$count = 0;

		return view('dashboard.admin.delegations', ['count' => $count,
			'delegations' => $delegations, 'delegates' => $delegates]);
	}

	public function delegation(User $user)
	{
		$count = 0;
		$delegates = Delegate::all()->where('user_id', $user->id);

		$id = $user->id;

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $payment) {
			$paid_amount += $payment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get()) * 100;
		$amount_due = DashboardController::money_format('%#10n', (($cost - $paid_amount) / 100.0));
		$paid_amount = DashboardController::money_format('%#10n', $paid_amount / 100.0);
		$cost = DashboardController::money_format('%#10n', $cost / 100.0);

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		return view('dashboard.admin.delegation', ['delegates' => $delegates,
			'user' => $user, 'count' => $count,
			'cost' => $cost, 'paid_amount' => $paid_amount,
			'amount_due' => $amount_due, 'payments' => $payments]);
	}


	public function edit(Delegate $delegate)
	{
		$id = $delegate->user_id;
		$user = User::find($id);
		$delegates = Delegate::where('user_id', '=', $id)->get();

		$committees = Committee::all();

		$lunches = Lunch::all();

		return view('dashboard.admin.edit', ['delegate' => $delegate, 'delegates' => $delegates,
			'user' => $user, 'delegate' => $delegate, 'committees' => $committees,
			'lunches' => $lunches]);
	}

	public function payment()
	{
		$users = User::all();
		$payments = DB::table('payments')->get();
		$delegates = Delegate::all();

		$count = 0;

		return view('dashboard.admin.payment', ['count' => $count, 'users' => $users,
			'payments' => $payments, 'delegates' => $delegates,
		]);
	}

	public function addPayment(Request $request)
	{
		$users = User::all();
		$delegations = new \Illuminate\Database\Eloquent\Collection;
		$delegates = Delegate::all();

		foreach ($users as $user) {
			$user_id = $user->id;
			if (count(Admin::where('user_id', $user_id)->get()) != 1) {
				$delegations->add($user);
			}
		}
		$count = 0;

		return view('dashboard.admin.addpayment', ['delegations' => $delegations]);
	}

	public function createPayment(Request $request)
	{
		$this->validate($request, [
			'cents' => 'required|between:0,99|min:0',
			'dollars' => 'required|min:0|integer',
			'delegation' => 'required|min:1',
		]);

		$user = User::find($request->delegation);

		if ($request->cents < 0) {
			return Redirect::back()->withErrors('Cents must be positive or zero');
		}

		$cents = (double)($request->cents);
		if ($cents % 1 != 0) {
			return Redirect::back()->withErrors('Cents must be an integer');
		}

		$amount = $request->dollars * 100 + $request->cents;

		$date = Carbon::now();
		$date->setTimezone('EST');
		$time = $date->toDateTimeString();

		DB::insert('insert into payments (user_id, amount, created_at) values (?, ?, ?)', [$request->delegation, $amount, $time]);

		$id = $user->id;

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $payment) {
			$paid_amount += $payment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get());
		$amount_due = DashboardController::money_format('%#10n', $cost - $paid_amount/100);
		$paid_amount = DashboardController::money_format('%#10n', $paid_amount/100);
		$cost = DashboardController::money_format('%#10n', $cost);

		$payment = DB::select('select * from payments where user_id = ? and created_at = ?', [$id, $time]);

		$num = $payment[0]->id;

		Mail::send('emails.addedPayment', ['user' => $user, 'cost' => $cost,
				'amount_due' => $amount_due, 'paid_amount' => $paid_amount,
				'amount' => DashboardController::money_format('%#10n', $amount / 100.0)]
			, function ($m) use (
				$num, $user, $cost,
				$amount_due, $paid_amount
			) {
				$m->from('mun@stjohnsprep.org', 'SJP MUN');

				$m->to($user->email, $user->name)->subject('Payment #' . $num . ' Recieved');
			});

		return redirect('/admin/payment');
	}

	public function deletePayment($paymentnum)
	{

		$usersPayments = DB::select('select * from payments where id = ?', [$paymentnum]);

		$id = $usersPayments[0]->user_id;

		$user = User::find($id);

		DB::table('payments')->delete($paymentnum);

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $subpayment) {
			$paid_amount += $subpayment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get());
		$amount_due = DashboardController::money_format('%#10n', $cost - $paid_amount);
		$paid_amount = DashboardController::money_format('%#10n', $paid_amount/100);
		$cost = DashboardController::money_format('%#10n', $cost);

		Mail::send('emails.deletedPayment', ['user' => $user, 'cost' => $cost,
				'amount_due' => $amount_due, 'paid_amount' => $paid_amount]
			, function ($m) use (
				$paymentnum, $user, $cost,
				$amount_due, $paid_amount
			) {
				$m->from('mun@stjohnsprep.org', 'SJP MUN');

				$m->to($user->email, $user->name)->subject('Payment # ' . $paymentnum . ' Declined');
			});

		return back();
	}

	public function positions() {
		$positions = position::all();
		$committees = Committee::all();
		$delegates = Delegate::all();
		$users = User::all();
		return view('dashboard.admin.positions',['positions' => $positions, 'count'=>0,
		'committees'=>$committees, 'delegates'=>$delegates, 'users'=>$users]);
	}

	public function committees() {
		$positions = position::all();
		$committees = Committee::all();
		$delegates = Delegate::all();
		$users = User::all();
		return view('dashboard.admin.committees', ['positions' => $positions, 'count'=>0,
			'committees'=>$committees, 'delegates'=>$delegates, 'users'=>$users]);
	}

	public function addCommittee() {
		return view('dashboard.admin.addCommittee');
	}

	public function createCommittee(Request $request) {
		$this->validate($request, [
			'abbreviation' => 'alpha|required',
			'chair_email' => 'email|required',
			'chair_name' => 'required',
			'name'=> 'required',
			'topic'=>'required'


		]);

		$committee = new Committee();
		$committee->full_name = $request->name;
		$committee->topic = $request->topic;
		$committee->chair_email = $request->chair_email;
		$committee->chair_name = $request->chair_name;
		$committee->committee = $request->abbreviation;

		$committee->save();

		return redirect('/admin/committees');
	}

	public function deleteCommittee(Committee $committee) {
		$committee->delete();
		return back();
	}

	public function editCommittee(Committee $committee) {
		return view('dashboard.admin.editCommittee', ['committee'=>$committee]);
	}

	public function editCommitteeSubmit(Committee $committee, Request $request) {
		$this->validate($request, [
			'abbreviation' => 'alpha|required',
			'chair_email' => 'email|required',
			'chair_name' => 'required',
			'name'=> 'required',
			'topic'=>'required'
		]);

		$committee->full_name = $request->name;
		$committee->topic = $request->topic;
		$committee->chair_email = $request->chair_email;
		$committee->chair_name = $request->chair_name;
		$committee->committee = $request->abbreviation;

		$committee->save();

		return redirect('/admin/committees');
	}

	public function addLunch() {
		return view('dashboard.admin.addLunch');
	}

	public function createLunch(Request $request) {
		$this->validate($request, [
			'name' => 'required|unique:lunches',
		]);

		$lunch = new Lunch();
		$lunch->name = $request->name;

		$lunch->save();

		return redirect('/admin/lunches');
	}

	public function deleteLunch(Lunch $lunch) {
		$lunch->delete();

		return back();
	}

	public function addAPosition() {
		$committees = Committee::all();

		return view('dashboard.admin.addAPosition', ['committees'=>$committees]);
	}

	public function addPositions() {
		return view('dashboard.admin.addPositions');
	}

}