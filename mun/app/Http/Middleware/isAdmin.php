<?php

namespace App\Http\Middleware;

use Closure;
use App\admin;
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
    public function handle($request, Closure $next)
    {
        $user_id = $request->user()->id;
        if(count(admin::all()->where('user_id', '=', $user_id)) != 1) {
            DB::table('unathorizedAttempts')->insert(
                ['ip' => $request->getClientIp(), 'user_id' => $user_id,
                'at'=> Carbon::now()->toDateTimeString()]
            );


            abort(403);
        }
        return $next($request);
    }
}
