<?php

namespace App\Http\Middleware;

use Closure;

class CancelAnyActiveSubscriptions
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
        $user = $request->user();
        $subscription = $user->subscription();

        if ($subscription and $subscription->active()) {
            $user->subscription()->cancelNow();
        }

        return $next($request);
    }
}
