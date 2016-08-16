<?php

use Illuminate\http\Request;
use App\User;
use App\Admin;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', function () {
		return view('welcome');
	});
});

Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('/admin/delegates', 'AdminController@delegates');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/manage', 'DashboardController@manage');
Route::get('/dashboard/payment', 'DashboardController@payment');
Route::get('/dashboard/{delegate}/delete', function(App\Delegate $delegate) {
	$user_id = Auth::id();

	if(count(Admin::where('user_id', Auth::id())->get()) != 0) {
		$delegate->delete();
	}
	else if($delegate->user_id == $user_id) {
		$delegate->delete();
	} else {
		abort(403);
	}
	return back();
});
Route::get('/dashboard/{delegate}/edit', 'DashboardController@edit');
Route::get('/dashboard/admin/{delegate}/edit', 'AdminController@edit');
Route::post('/users/{user}/delegates', 'DashboardController@addDelegate');
Route::post('/delegates/{delegate}/edit', 'DashboardController@editDelegate');
Route::get('/dashboards/admin', 'AdminController@index');
Route::get('/admin', 'AdminController@index');
Route::get('/admin/delegations', 'AdminController@delegations');
Route::get('/dashboard/admin/delgation/{user}', 'AdminController@delegation');
Route::get('/admin/payment', 'AdminController@payment');
Route::get('/dashboard/admin/addPayment', 'AdminController@addPayment');
Route::post('/dashboard/admin/addPayment/add', 'AdminController@createPayment');
Route::get('/dashboard/admin/deletePayment/{payment}', 'AdminController@deletePayment');
Route::get('/admin/positions', 'AdminController@positions');
Route::get('/admin/committees', 'AdminController@committees');
Route::get('/admin/addCommittee', 'AdminController@addCommittee');
Route::post('/admin/addCommittee/add', 'AdminController@createCommittee');
Route::get('/admin/committees/{committee}/delete', 'AdminController@deleteCommittee');
Route::get('/admin/committees/{committee}/edit', 'AdminController@editCommittee');
Route::post('/admin/addCommittee/{committee}/edit', 'AdminController@editCommitteeSubmit');
Route::get('/admin/lunches', 'AdminController@lunches');
Route::get('/admin/addLunch', 'AdminController@addLunch');
Route::post('/dashboard/admin/addLunch/add', 'AdminController@createLunch');
Route::get('/admin/lunches/{lunch}/delete', 'AdminController@deleteLunch');
Route::get('/admin/addAPosition', 'AdminController@addAPosition');
Route::get('/admin/addPositions', 'AdminController@addPositions');