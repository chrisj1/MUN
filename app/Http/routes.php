<?php

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
Route::get('/aboutUs', function () {
	return view('aboutUs');
});
Route::get('/directions', function () {
	return view('directions');
});
Route::get('/campusMap', function () {
	return view('map');
});
Route::get('/home', 'HomeController@index');
Route::get('/admin/delegates', 'AdminController@delegates');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/manage', 'DashboardController@manage');
Route::get('/dashboard/payment', 'DashboardController@payment');
Route::get('/dashboard/{delegate}/delete', function (App\Delegate $delegate) {
	$user_id = Auth::id();

	if (count(Admin::where('user_id', Auth::id())->get()) != 0) {
		$delegate->delete();
	} else if ($delegate->user_id == $user_id) {
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
Route::get('/admin/addPosition', 'AdminController@addAPosition');
Route::get('/admin/committees/{committee}/clone', 'AdminController@cloneCommitteeView');
Route::post('/admin/addPosition', 'AdminController@createPosition');
Route::post('/admin/{committee}/clone/add', 'AdminController@createClone');
Route::get('/admin/papers', 'AdminController@briefingPapers');
Route::get('/download/{briefingPaper}', 'DashboardController@downloadPaper');
Route::get('/admin/addPaper', 'AdminController@addPaper');
Route::post('admin/addPaper', 'AdminController@addAPaper');
Route::get('/admin/assignPositions', 'AdminController@assignPositions');
Route::get('admin/{user}/assign', 'AdminController@userAssign');
Route::post('/admin/{user}/assign', 'AdminController@postAssign');
Route::get('/dashboard/requests', 'DashboardController@requests');
Route::post('/users/{user}/request', 'DashboardController@requestPos');
Route::get("/dashboard/autoassign/{user}", 'AdminController@beginAutoAssign');
Route::get('/admin/admin', 'AdminController@admin');
Route::get('assignChair/{committee}/{user}', function () {
	return redirect("http://www.stjohnsprep.org/uploaded/pdf_files/map/campus_guide_1516_final.pdf");
});
Route::get('/418', function () {
	abort(418);
});
Route::get('/committees/{name}', function ($name){
	error_log($name);
	return view('committees.' . $name);
});
Route::get('/chair/register', 'ChairController@register');
Route::get('/admin/position/{position}/delete', function (App\Position $position){
	$position->delete();
	return back();
});