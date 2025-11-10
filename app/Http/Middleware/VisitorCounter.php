<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Visitor;
use Carbon\Carbon;

class VisitorCounter
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

        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $page = $request->path();
        $today = Carbon::today()->toDateString();

        // Cek apakah IP sudah tercatat hari ini
        $exists = Visitor::where('ip_address', $ip)
            ->where('visited_date', $today)
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'page' => $page,
                'visited_date' => $today,
            ]);
        }

        return $next($request);
    }
}
