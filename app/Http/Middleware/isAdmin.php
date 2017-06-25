<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
	    $user = $request->user();
	    error_log($user->isAdmin());
	    if($user->isAdmin()) {
		    return $next($request);
	    }

        /*$user_id = $request->user()->id;
	    if(count(Admin::where('user_id', $user_id)->get()) != 1) {
		    DB::table('unathorizedAttempts')->insert(
			    ['ip' => $request->getClientIp(), 'user_id' => $user_id,
				    'at'=> Carbon::now()->toDateTimeString()]
		    );
		    abort(403);
	    }*/
	    DB::table('unathorizedAttempts')->insert(
		    ['ip' => $request->getClientIp(), 'user_id' => $user->id,
			    'at'=> Carbon::now()->toDateTimeString()]
	    );
	    abort(403);
    }
}
