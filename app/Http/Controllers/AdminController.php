<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BriefingPaper;
use App\Committee;
use App\Delegate;
use App\Lunch;
use App\Position;
use App\User;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller {
	/**
	 * AdminController constructor.
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('isAdmin');
	}

	/**
	 * Returns the main dashboard page for admins
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
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
	public function delegates() {
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
	public function lunches() {
		$delegates = Delegate::all();
		$users = User::all();
		$lunches = Lunch::all();
		$committees = Committee::all();

		return view('dashboard.admin.lunches', ['delegates' => $delegates, 'users' => $users, 'lunches' => $lunches, 'committees' => $committees]);
	}

	public function delegations() {
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

		return view('dashboard.admin.delegations', ['count' => $count, 'delegations' => $delegations, 'delegates' => $delegates]);
	}

	public function delegation(User $user) {
		$count = 0;
		$delegates = Delegate::all()->where('user_id', $user->id);

		$id = $user->id;

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $payment) {
			$paid_amount += $payment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get()) * 100;
		$amount_due = Utils::money_format('%#10n', (($cost - $paid_amount) / 100.0));
		$paid_amount = Utils::money_format('%#10n', $paid_amount / 100.0);
		$cost = Utils::money_format('%#10n', $cost / 100.0);

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		return view('dashboard.admin.delegation', ['delegates' => $delegates, 'user' => $user, 'count' => $count, 'cost' => $cost, 'paid_amount' => $paid_amount, 'amount_due' => $amount_due, 'payments' => $payments]);
	}

	public function edit(Delegate $delegate) {
		$id = $delegate->user_id;
		$user = User::find($id);
		$delegates = Delegate::where('user_id', '=', $id)->get();

		$committees = Committee::all();

		$lunches = Lunch::all();

		return view('dashboard.admin.edit', ['delegate' => $delegate, 'delegates' => $delegates, 'user' => $user, 'delegate' => $delegate, 'committees' => $committees, 'lunches' => $lunches]);
	}

	public function payment() {
		$users = User::all();
		$payments = DB::table('payments')->get();
		$delegates = Delegate::all();

		$count = 0;

		return view('dashboard.admin.payment', ['count' => $count, 'users' => $users, 'payments' => $payments, 'delegates' => $delegates,]);
	}

	public function addPayment(Request $request) {
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

	public function createPayment(Request $request) {
		$this->validate($request, ['cents' => 'required|between:0,99|min:0', 'dollars' => 'required|min:0|integer', 'delegation' => 'required|min:1',]);

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
		$note = $request->note;

		DB::insert('insert into payments (user_id, amount, created_at, note) values (?, ?, ?, ?)', [$request->delegation, $amount, $time, $note]);

		$id = $user->id;

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $payment) {
			$paid_amount += $payment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get()) + DashboardController::$registartion_fee;
		$amount_due = DashboardController::money_format('%#10n', $cost - $paid_amount / 100 + DashboardController::$registartion_fee);
		$paid_amount = DashboardController::money_format('%#10n', $paid_amount / 100);
		$cost = DashboardController::money_format('%#10n', $cost);

		$payment = DB::select('select * from payments where user_id = ? and created_at = ?', [$id, $time]);

		$num = $payment[0]->id;

		Mail::send('emails.addedPayment', ['user' => $user, 'cost' => $cost, 'amount_due' => $amount_due, 'paid_amount' => $paid_amount, 'amount' => DashboardController::money_format('%#10n', $amount / 100.0)], function ($m) use (
			$num, $user, $cost, $amount_due, $paid_amount
		) {
			$m->from('mun@stjohnsprep.org', 'SJP MUN');

			$m->to($user->email, $user->name)->subject('Payment #' . $num . ' Recieved');
		});

		return redirect('/admin/payment');
	}

	public function deletePayment($paymentnum) {

		$usersPayments = DB::select('select * from payments where id = ?', [$paymentnum]);

		$id = $usersPayments[0]->user_id;

		$user = User::find($id);

		DB::table('payments')->delete($paymentnum);

		$payments = DB::select('select * from payments where user_id = ?', [$id]);

		$paid_amount = 0;
		foreach ($payments as $subpayment) {
			$paid_amount += $subpayment->amount;
		}
		$cost = DashboardController::$price_per_delegate * count(Delegate::where('user_id', '=', $id)->get()) + DashboardController::$registartion_fee;
		$amount_due = DashboardController::money_format('%#10n', $cost - $paid_amount / 100 + DashboardController::$registartion_fee);
		$paid_amount = DashboardController::money_format('%#10n', $paid_amount / 100);
		$cost = DashboardController::money_format('%#10n', $cost);

		Mail::send('emails.deletedPayment', ['user' => $user, 'cost' => $cost, 'amount_due' => $amount_due, 'paid_amount' => $paid_amount], function ($m) use (
			$paymentnum, $user, $cost, $amount_due, $paid_amount
		) {
			$m->from('mun@stjohnsprep.org', 'SJP MUN');

			$m->to($user->email, $user->name)->subject('Payment # ' . $paymentnum . ' Declined');
		});

		return back();
	}

	public function positions() {
		$positions = Position::all();
		$committees = Committee::all();
		$delegates = Delegate::all();
		$users = User::all();
		return view('dashboard.admin.positions', ['positions' => $positions, 'count' => 0, 'committees' => $committees, 'delegates' => $delegates, 'users' => $users]);
	}

	public function committees() {
		$positions = Position::all();
		$committees = Committee::all();
		$delegates = Delegate::all();
		$users = User::all();
		return view('dashboard.admin.committees', ['positions' => $positions, 'count' => 0, 'committees' => $committees, 'delegates' => $delegates, 'users' => $users]);
	}

	public function addCommittee() {
		return view('dashboard.admin.addCommittee');
	}

	public function createCommittee(Request $request) {
		$this->validate($request, ['abbreviation' => 'required', //'chair_email' => 'email|required',
			//'chair_name' => 'required',
			'name' => 'required', 'topic' => 'required', 'level' => 'required']);

		$committee = new Committee();
		$committee->full_name = $request->name;
		$committee->topic = $request->topic;
		$committee->notes = $request->notes;
		$committee->level = $request->level;
		//$committee->chair_email = $request->chair_email;
		//$committee->chair_name = $request->chair_name;
		$committee->committee = $request->abbreviation;
		$committee->high_school = !$request->high_school;

		//return $request;

		//return $request;

		$committee->save();

		return redirect('/admin/committees');
	}

	public function deleteCommittee(Committee $committee) {
		$positions = Position::all()->where('committee_id', $committee->id);
		$requests = \App\Request::all()->where('committee_id', $committee->id);
		foreach ($positions as $position) {
			$position->delete();
		}
		foreach ($requests as $request) {
			$request->delete();
		}

		$committee->delete();
		return back();
	}

	public function editCommittee(Committee $committee) {
		return view('dashboard.admin.editCommittee', ['committee' => $committee]);
	}

	public function editCommitteeSubmit(Committee $committee, Request $request) {
		$this->validate($request, ['abbreviation' => 'alpha|required', 'chair_email' => 'email|required', 'chair_name' => 'required', 'name' => 'required', 'topic' => 'required']);

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
		$this->validate($request, ['name' => 'required|unique:lunches',]);

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

		return view('dashboard.admin.addAPosition', ['committees' => $committees]);
	}

	public function addPositions() {
		$committees = Committee::all();
		return view('dashboard.admin.addPositions', ['committees' => $committees, 'last' => null]);
	}

	public function cloneCommitteeView(Committee $committee) {
		$positions = Position::all()->where('committee_id', $committee->id);

		return view('dashboard.admin.cloneCommittee', ['committee' => $committee, 'positions' => $positions]);
	}

	public function createPosition(Request $request) {

		$this->processNewPositionRequest($request);
		error_log($request->committee);

		return redirect('/admin/positions');
	}

	public function createPositions(Request $request) {

		$position = $this->processNewPositionRequest($request);
		$committees = Committee::all();

		return view('dashboard.admin.addPositions', ['last' => $position, 'committees' => $committees]);
	}

	public function createClone(Request $request, Committee $committee) {
		$positions = Input::get('positions');
		$newCommittee = new Committee();
		$newCommittee->committee = $committee->committee;
		$newCommittee->full_name = $committee->full_name;
		$newCommittee->topic = $committee->topic;
		$newCommittee->clone_of = $committee->id;
		$newCommittee->level = $committee->level;
		$newCommittee->high_school = $committee->high_school;
		$newCommittee->save();

		if (count($positions) > 0) {
			foreach ($positions as $key => $position) {
				$selectedPosition = Position::find($key);
				$newPosition = new Position();
				$newPosition->committee_id = $newCommittee->id;
				$newPosition->name = $selectedPosition->name;
				$newPosition->save();
			}
		}

		return redirect("/admin/committees");
	}

	public function briefingPapers() {
		return view('dashboard.admin.papers', ['papers' => BriefingPaper::all(), 'committees' => Committee::all()]);
	}

	public function addPaper() {
		$committees = Committee::all()->where('clone_of', null);

		return view('dashboard.admin.addPaper', ['committees' => $committees]);
	}

	public function addAPaper(Request $request) {
		$this->validate($request, ['name' => 'required|unique:briefing_papers',]);

		if (strcmp($request->file('paper')->guessExtension(), 'pdf')) {
			return back()->withErrors('File must be of type pdf');
		}

		$paper = new BriefingPaper();
		$paper->committee_id = $request->committee;
		$paper->name = $request->name;
		$paper->save();

		$fileName = $paper->id . '.' . $request->file('paper')->getClientOriginalExtension();

		$path = base_path() . '/storage/app/papers/';

		$request->file('paper')->move($path, $fileName);

		$paper->file_path = $path . $fileName;
		$paper->save();

		return redirect('/admin/papers');
	}

	public function assignPositions(User $user, Request $request) {
		$committees = Committee::all();
		$positions = Position::all();
		$users = User::all();
		$delegates = Delegate::all();
		$requests = \App\Request::all();

		$delegations = new Collection();
		foreach ($users as $user) {
			if (!$this->userIsAdmin($user->id)) {
				$delegations->add($user);
			}
		}

		return view('dashboard.admin.assignPositions', ['committees' => $committees, 'positions' => $positions, 'users' => $delegations, 'delegates' => $delegates, 'requests' => $requests]);
	}

	public function userIsAdmin($user_id) {
		if (Admin::where('user_id', '=', $user_id)->exists()) {
			return true;
		}
		return false;
	}

	public function userAssign(User $user) {
		$positions = Position::all();
		$committees = Committee::all();
		$delegates = Delegate::all()->where('user_id', $user->id);

		$genPos = new Collection();
		foreach ($positions as $position) {
			$genPo = new GenericPosition();
			$genPo->position = $position;
			$committee = Committee::find($position->committee_id);
			if (isset($position->user_id) && $position->user_id != $user->id) {
				continue;
			}
			if (isset($committee->clone_of)) {
				$genPo->committee = $committee;
			} else {
				$genPo->committee = Committee::find($committee->clone_of);
			}
			$genPos->add($genPo);
		}
		return view('dashboard.admin.assignPositionDelegation', ['positions' => $genPos, 'committees' => $committees, 'delegates' => $delegates, 'user' => $user]);
	}

	public function postAssign(User $user, Request $request) {
		$positions = Position::all();
		$positions = $positions->where('user_id', null)->union($positions->where('user_id', $user->id));

		if (count($positions) > 0) {
			foreach ($positions as $position) {
				$position->user_id = null;
				$position->save();
			}
		}

		$selectedPositions = Input::get('position');
		if (count($selectedPositions) > 0) {
			foreach ($selectedPositions as $key => $position) {
				$selectedposition = Position::find($key);
				$selectedposition->user_id = $user->id;
				$selectedposition->save();
			}
		}
		return back();
	}

	public function beginAutoAssign(User $user) {
		return $this->autoAssignDelegation($user);
	}

	public function autoAssignDelegation(User $user) {
		$allRequests = \App\Request::all()->where('user_id', $user->id);

		$array = $allRequests->toArray();
		usort($array, array($this, "compareCommitteePopularity"));

		return $array;
	}

	function compareCommitteePopularity($a, $b) {
		$a_pop = $this->rankCommitteePopularity(new Committee($a));
		$b_pop = $this->rankCommitteePopularity(new Committee($b));
		if ($a_pop < $b_pop) {
			return -1;
		} elseif ($a_pop > $b_pop) {
			return 1;
		}
		return 0;
	}


	/**
	 * Ranks committee popularity vs spots availible
	 */
	public function rankCommitteePopularity(Committee $committee) {
		$positions = count((Position::all()->where('committee_id', $committee->id)));
		$requests_raw = \App\Request::all()->where('committee_id', $committee->id);
		$total_requests = 0;
		foreach ($requests_raw as $r) {
			$total_requests += $r->amount;
		}
		if ($positions == 0)
			return -1;
		return ((float)$total_requests) / $positions;

	}

	public function admin() {
		$users = User::all();

		return view('dashboard.admin.admin', ['users' => $users]);
	}

	public function newPosition($committee, $name) {
		$position = new Position();
		$position->committee_id = $committee;
		$position->name = $name;
		$position->save();
	}

	/**
	 * @param Request $request
	 */
	public function processNewPositionRequest(Request $request) {
		$names = explode(",", $request->position);
		$lastPosition = null;
		foreach ($names as $name) {
			$lastPosition = $this->newPosition($request->committee, trim($name));
		}
		return $lastPosition;
	}

}