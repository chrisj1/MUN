<?php

use Illuminate\http\Request;

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


Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/manage', 'DashboardController@manage');

Route::get('/dashboard/payment', 'DashboardController@payment');

Route::get('/dashboard/{delegate}/delete', function(App\Delegate $delegate) {
	$user_id = Auth::id();
	if($delegate->user_id == $user_id) {
		$delegate->delete();
	}
	return back();
});

Route::get('/dashboard/{delegate}/edit', 'DashboardController@edit');

Route::post('/users/{user}/delegates', 'DashboardController@addDelegate');

Route::post('/delegates/{delegate}/edit', 'DashboardController@editDelegate');

Route::get('/dashboards/admin', 'AdminController@index');
Route::get('/admin', 'AdminController@index');

Route::get('/email', function(Request $request) {
    Mail::raw('text to email', function($message) {
        $message->to('chrisjjerrett@gmail.com');
    });
    return $request;
});


