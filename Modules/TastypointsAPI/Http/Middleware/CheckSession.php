<?php

namespace Modules\TastypointsAPI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use URL;

class checkSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session::has("tasty_session")){
            $session = $request->session()->get("tasty_session");
            $json = json_decode($session);
            $session_exp = Carbon::parse($json->session_exp);
            $now = Carbon::now();
            $diff = $session_exp->diffInSeconds($now);

            $request->attributes->add(['session' => $json]);

            if($diff > 0){
                // DD($json);
                return $next($request);
            }
        }
        // DD();
        $request->session()->put("initiate_url",$request->url());
        return redirect()->route("tastypointsapi.verification");
    }
}
